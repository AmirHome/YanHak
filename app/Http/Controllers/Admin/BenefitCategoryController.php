<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBenefitCategoryRequest;
use App\Http\Requests\StoreBenefitCategoryRequest;
use App\Http\Requests\UpdateBenefitCategoryRequest;
use App\Models\BenefitCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BenefitCategory::with(['team'])->select(sprintf('%s.*', (new BenefitCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_category_show';
                $editGate      = 'benefit_category_edit';
                $deleteGate    = 'benefit_category_delete';
                $crudRoutePart = 'benefit-categories';

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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.benefitCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.benefitCategories.create');
    }

    public function store(StoreBenefitCategoryRequest $request)
    {
        $benefitCategory = BenefitCategory::create($request->all());

        return redirect()->route('admin.benefit-categories.index');
    }

    public function edit(BenefitCategory $benefitCategory)
    {
        abort_if(Gate::denies('benefit_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCategory->load('team');

        return view('admin.benefitCategories.edit', compact('benefitCategory'));
    }

    public function update(UpdateBenefitCategoryRequest $request, BenefitCategory $benefitCategory)
    {
        $benefitCategory->update($request->all());

        return redirect()->route('admin.benefit-categories.index');
    }

    public function show(BenefitCategory $benefitCategory)
    {
        abort_if(Gate::denies('benefit_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCategory->load('team', 'categoryBenefits');

        return view('admin.benefitCategories.show', compact('benefitCategory'));
    }

    public function destroy(BenefitCategory $benefitCategory)
    {
        abort_if(Gate::denies('benefit_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitCategoryRequest $request)
    {
        $benefitCategories = BenefitCategory::find(request('ids'));

        foreach ($benefitCategories as $benefitCategory) {
            $benefitCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
