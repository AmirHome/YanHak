<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBenefitVariantRequest;
use App\Http\Requests\StoreBenefitVariantRequest;
use App\Http\Requests\UpdateBenefitVariantRequest;
use App\Models\Benefit;
use App\Models\BenefitVariant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitVariantController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BenefitVariant::with(['benefit', 'team'])->select(sprintf('%s.*', (new BenefitVariant)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_variant_show';
                $editGate      = 'benefit_variant_edit';
                $deleteGate    = 'benefit_variant_delete';
                $crudRoutePart = 'benefit-variants';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('credit_amount', function ($row) {
                return $row->credit_amount ? $row->credit_amount : '';
            });

            $table->editColumn('satus', function ($row) {
                return $row->satus ? BenefitVariant::SATUS_RADIO[$row->satus] : '';
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
            $table->addColumn('benefit_name', function ($row) {
                return $row->benefit ? $row->benefit->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'picture', 'benefit']);

            return $table->make(true);
        }

        return view('admin.benefitVariants.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_variant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.benefitVariants.create', compact('benefits'));
    }

    public function store(StoreBenefitVariantRequest $request)
    {
        $benefitVariant = BenefitVariant::create($request->all());

        if ($request->input('picture', false)) {
            $benefitVariant->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $benefitVariant->id]);
        }

        return redirect()->route('admin.benefit-variants.index');
    }

    public function edit(BenefitVariant $benefitVariant)
    {
        abort_if(Gate::denies('benefit_variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $benefitVariant->load('benefit', 'team');

        return view('admin.benefitVariants.edit', compact('benefitVariant', 'benefits'));
    }

    public function update(UpdateBenefitVariantRequest $request, BenefitVariant $benefitVariant)
    {
        $benefitVariant->update($request->all());

        if ($request->input('picture', false)) {
            if (! $benefitVariant->picture || $request->input('picture') !== $benefitVariant->picture->file_name) {
                if ($benefitVariant->picture) {
                    $benefitVariant->picture->delete();
                }
                $benefitVariant->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
            }
        } elseif ($benefitVariant->picture) {
            $benefitVariant->picture->delete();
        }

        return redirect()->route('admin.benefit-variants.index');
    }

    public function show(BenefitVariant $benefitVariant)
    {
        abort_if(Gate::denies('benefit_variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitVariant->load('benefit', 'team', 'variantBenefits', 'benfitvariantEmployees', 'benefitBenefitPackages');

        return view('admin.benefitVariants.show', compact('benefitVariant'));
    }

    public function destroy(BenefitVariant $benefitVariant)
    {
        abort_if(Gate::denies('benefit_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitVariant->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitVariantRequest $request)
    {
        $benefitVariants = BenefitVariant::find(request('ids'));

        foreach ($benefitVariants as $benefitVariant) {
            $benefitVariant->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('benefit_variant_create') && Gate::denies('benefit_variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BenefitVariant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
