<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVariantRequest;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Models\Benefit;
use App\Models\Variant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VariantController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Variant::with(['benefit', 'team'])->select(sprintf('%s.*', (new Variant)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'variant_show';
                $editGate      = 'variant_edit';
                $deleteGate    = 'variant_delete';
                $crudRoutePart = 'variants';

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

            $table->editColumn('status', function ($row) {
                return $row->status ? Variant::STATUS_SELECT[$row->status] : '';
            });
            $table->addColumn('benefit_title', function ($row) {
                return $row->benefit ? $row->benefit->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'benefit']);

            return $table->make(true);
        }

        return view('admin.variants.index');
    }

    public function create()
    {
        abort_if(Gate::denies('variant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.variants.create', compact('benefits'));
    }

    public function store(StoreVariantRequest $request)
    {
        $variant = Variant::create($request->all());

        return redirect()->route('admin.variants.index');
    }

    public function edit(Variant $variant)
    {
        abort_if(Gate::denies('variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $variant->load('benefit', 'team');

        return view('admin.variants.edit', compact('benefits', 'variant'));
    }

    public function update(UpdateVariantRequest $request, Variant $variant)
    {
        $variant->update($request->all());

        return redirect()->route('admin.variants.index');
    }

    public function show(Variant $variant)
    {
        abort_if(Gate::denies('variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $variant->load('benefit', 'team');

        return view('admin.variants.show', compact('variant'));
    }

    public function destroy(Variant $variant)
    {
        abort_if(Gate::denies('variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $variant->delete();

        return back();
    }

    public function massDestroy(MassDestroyVariantRequest $request)
    {
        $variants = Variant::find(request('ids'));

        foreach ($variants as $variant) {
            $variant->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
