<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBenefitPackageRequest;
use App\Http\Requests\StoreBenefitPackageRequest;
use App\Http\Requests\UpdateBenefitPackageRequest;
use App\Models\BenefitPackage;
use App\Models\BenefitVariant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitPackageController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BenefitPackage::with(['benefits', 'team'])->select(sprintf('%s.*', (new BenefitPackage)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_package_show';
                $editGate      = 'benefit_package_edit';
                $deleteGate    = 'benefit_package_delete';
                $crudRoutePart = 'benefit-packages';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
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
            $table->editColumn('credit_amount', function ($row) {
                return $row->credit_amount ? $row->credit_amount : '';
            });
            $table->editColumn('benefit', function ($row) {
                $labels = [];
                foreach ($row->benefits as $benefit) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $benefit->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('team_name', function ($row) {
                return $row->team ? $row->team->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'picture', 'benefit', 'team']);

            return $table->make(true);
        }

        return view('admin.benefitPackages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = BenefitVariant::pluck('name', 'id');

        return view('admin.benefitPackages.create', compact('benefits'));
    }

    public function store(StoreBenefitPackageRequest $request)
    {
        $benefitPackage = BenefitPackage::create($request->all());
        $benefitPackage->benefits()->sync($request->input('benefits', []));
        if ($request->input('picture', false)) {
            $benefitPackage->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $benefitPackage->id]);
        }

        return redirect()->route('admin.benefit-packages.index');
    }

    public function edit(BenefitPackage $benefitPackage)
    {
        abort_if(Gate::denies('benefit_package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = BenefitVariant::pluck('name', 'id');

        $benefitPackage->load('benefits', 'team');

        return view('admin.benefitPackages.edit', compact('benefitPackage', 'benefits'));
    }

    public function update(UpdateBenefitPackageRequest $request, BenefitPackage $benefitPackage)
    {
        $benefitPackage->update($request->all());
        $benefitPackage->benefits()->sync($request->input('benefits', []));
        if ($request->input('picture', false)) {
            if (! $benefitPackage->picture || $request->input('picture') !== $benefitPackage->picture->file_name) {
                if ($benefitPackage->picture) {
                    $benefitPackage->picture->delete();
                }
                $benefitPackage->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
            }
        } elseif ($benefitPackage->picture) {
            $benefitPackage->picture->delete();
        }

        return redirect()->route('admin.benefit-packages.index');
    }

    public function show(BenefitPackage $benefitPackage)
    {
        abort_if(Gate::denies('benefit_package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitPackage->load('benefits', 'team', 'benefitPackagesEmployees');

        return view('admin.benefitPackages.show', compact('benefitPackage'));
    }

    public function destroy(BenefitPackage $benefitPackage)
    {
        abort_if(Gate::denies('benefit_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitPackage->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitPackageRequest $request)
    {
        $benefitPackages = BenefitPackage::find(request('ids'));

        foreach ($benefitPackages as $benefitPackage) {
            $benefitPackage->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('benefit_package_create') && Gate::denies('benefit_package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BenefitPackage();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
