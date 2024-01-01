<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBenefitCompanyRequest;
use App\Http\Requests\UpdateBenefitCompanyRequest;
use App\Http\Resources\Admin\BenefitCompanyResource;
use App\Models\BenefitCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitCompanyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('benefit_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitCompanyResource(BenefitCompany::with(['team'])->get());
    }

    public function store(StoreBenefitCompanyRequest $request)
    {
        $benefitCompany = BenefitCompany::create($request->all());

        return (new BenefitCompanyResource($benefitCompany))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BenefitCompany $benefitCompany)
    {
        abort_if(Gate::denies('benefit_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitCompanyResource($benefitCompany->load(['team']));
    }

    public function update(UpdateBenefitCompanyRequest $request, BenefitCompany $benefitCompany)
    {
        $benefitCompany->update($request->all());

        return (new BenefitCompanyResource($benefitCompany))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BenefitCompany $benefitCompany)
    {
        abort_if(Gate::denies('benefit_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCompany->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
