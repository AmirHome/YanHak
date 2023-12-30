<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBenefitCategoryRequest;
use App\Http\Requests\UpdateBenefitCategoryRequest;
use App\Http\Resources\Admin\BenefitCategoryResource;
use App\Models\BenefitCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('benefit_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitCategoryResource(BenefitCategory::with(['team'])->get());
    }

    public function store(StoreBenefitCategoryRequest $request)
    {
        $benefitCategory = BenefitCategory::create($request->all());

        return (new BenefitCategoryResource($benefitCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BenefitCategory $benefitCategory)
    {
        abort_if(Gate::denies('benefit_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitCategoryResource($benefitCategory->load(['team']));
    }

    public function update(UpdateBenefitCategoryRequest $request, BenefitCategory $benefitCategory)
    {
        $benefitCategory->update($request->all());

        return (new BenefitCategoryResource($benefitCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BenefitCategory $benefitCategory)
    {
        abort_if(Gate::denies('benefit_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
