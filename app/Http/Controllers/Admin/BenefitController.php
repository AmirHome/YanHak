<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBenefitRequest;
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Models\Benefit;
use App\Models\BenefitCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Benefit::with(['category', 'team'])->select(sprintf('%s.*', (new Benefit)->table));
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

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('credit_amount', function ($row) {
                return $row->credit_amount ? $row->credit_amount : '';
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
            $table->editColumn('status', function ($row) {
                return $row->status ? Benefit::STATUS_SELECT[$row->status] : '';
            });

            $table->addColumn('category_title', function ($row) {
                return $row->category ? $row->category->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'picture', 'category']);

            return $table->make(true);
        }

        return view('admin.benefits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = BenefitCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.benefits.create', compact('categories'));
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

        $categories = BenefitCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $benefit->load('category', 'team');

        return view('admin.benefits.edit', compact('benefit', 'categories'));
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

        $benefit->load('category', 'team', 'benefitEmployees');

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
