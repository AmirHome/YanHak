<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBenefitRequest;
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Models\Benefit;
use App\Models\BenefitCategory;
use App\Models\BenefitCompany;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Benefit::with(['category', 'benefit_company', 'team', 'variants'])->select(sprintf('%s.*', (new Benefit)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_show';
                $editGate      = 'benefit_edit';
                $deleteGate    = 'benefit_delete';
                $crudRoutePart = 'benefits';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->addColumn('benefit_company_name', function ($row) {
                return $row->benefit_company ? $row->benefit_company->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? Benefit::STATUS_RADIO[$row->status] : '';
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

            $table->addColumn('team_name', function ($row) {
                return $row->team ? $row->team->name : '';
            });

            $table->editColumn('variant', function ($row) {
                $labels = [];
                foreach ($row->variants as $variant) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $variant->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'benefit_company', 'picture', 'team', 'variant']);

            return $table->make(true);
        }

        return view('admin.benefits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = BenefitCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $benefit_companies = BenefitCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.benefits.create', compact('benefit_companies', 'categories'));
    }

    public function store(StoreBenefitRequest $request)
    {
        $benefit = Benefit::create($request->all());

        if ($request->input('picture', false)) {
            $benefit->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $benefit->id]);
        }

        return redirect()->route('admin.benefits.index');
    }

    public function edit(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = BenefitCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $benefit_companies = BenefitCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $benefit->load('category', 'benefit_company', 'team', 'variants');

        return view('admin.benefits.edit', compact('benefit', 'benefit_companies', 'categories'));
    }

    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        $benefit->update($request->all());

        if ($request->input('picture', false)) {
            if (! $benefit->picture || $request->input('picture') !== $benefit->picture->file_name) {
                if ($benefit->picture) {
                    $benefit->picture->delete();
                }
                $benefit->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
            }
        } elseif ($benefit->picture) {
            $benefit->picture->delete();
        }

        return redirect()->route('admin.benefits.index');
    }

    public function show(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->load('category', 'benefit_company', 'team', 'variants', 'benefitBenefitVariants');

        return view('admin.benefits.show', compact('benefit'));
    }

    public function destroy(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitRequest $request)
    {
        $benefits = Benefit::find(request('ids'));

        foreach ($benefits as $benefit) {
            $benefit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('benefit_create') && Gate::denies('benefit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Benefit();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
