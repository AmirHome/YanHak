<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\BenefitPackage;
use App\Models\BenefitVariant;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Employee::with(['team', 'benfitvariants', 'benefit_packages'])->select(sprintf('%s.*', (new Employee)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_show';
                $editGate      = 'employee_edit';
                $deleteGate    = 'employee_delete';
                $crudRoutePart = 'employees';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('team_name', function ($row) {
                return $row->team ? $row->team->name : '';
            });

            $table->editColumn('picture', function ($row) {
                if ($photo = $row->picture) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('sur_name', function ($row) {
                return $row->sur_name ? $row->sur_name : '';
            });
            $table->editColumn('working_type', function ($row) {
                return $row->working_type ? Employee::WORKING_TYPE_SELECT[$row->working_type] : '';
            });
            $table->editColumn('job_title', function ($row) {
                return $row->job_title ? $row->job_title : '';
            });
            $table->editColumn('department', function ($row) {
                return $row->department ? $row->department : '';
            });
            $table->editColumn('yearly_credit', function ($row) {
                return $row->yearly_credit ? $row->yearly_credit : '';
            });
            $table->editColumn('benfitvariant', function ($row) {
                $labels = [];
                foreach ($row->benfitvariants as $benfitvariant) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $benfitvariant->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('benefit_packages', function ($row) {
                $labels = [];
                foreach ($row->benefit_packages as $benefit_package) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $benefit_package->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'team', 'picture', 'benfitvariant', 'benefit_packages']);

            return $table->make(true);
        }

        return view('admin.employees.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benfitvariants = BenefitVariant::pluck('name', 'id');

        $benefit_packages = BenefitPackage::pluck('title', 'id');

        return view('admin.employees.create', compact('benefit_packages', 'benfitvariants'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());
        $employee->benfitvariants()->sync($request->input('benfitvariants', []));
        $employee->benefit_packages()->sync($request->input('benefit_packages', []));
        if ($request->input('picture', false)) {
            $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employee->id]);
        }

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benfitvariants = BenefitVariant::pluck('name', 'id');

        $benefit_packages = BenefitPackage::pluck('title', 'id');

        $employee->load('team', 'benfitvariants', 'benefit_packages');

        return view('admin.employees.edit', compact('benefit_packages', 'benfitvariants', 'employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());
        $employee->benfitvariants()->sync($request->input('benfitvariants', []));
        $employee->benefit_packages()->sync($request->input('benefit_packages', []));
        if ($request->input('picture', false)) {
            if (! $employee->picture || $request->input('picture') !== $employee->picture->file_name) {
                if ($employee->picture) {
                    $employee->picture->delete();
                }
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
            }
        } elseif ($employee->picture) {
            $employee->picture->delete();
        }

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('team', 'benfitvariants', 'benefit_packages');

        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        $employees = Employee::find(request('ids'));

        foreach ($employees as $employee) {
            $employee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_create') && Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Employee();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
