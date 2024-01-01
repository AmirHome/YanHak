<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBenefitPackageRequest;
use App\Http\Requests\UpdateBenefitPackageRequest;
use App\Http\Resources\Admin\BenefitPackageResource;
use App\Models\BenefitPackage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitPackageApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('benefit_package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitPackageResource(BenefitPackage::with(['benefits', 'team'])->get());
    }

    public function store(StoreBenefitPackageRequest $request)
    {
        $benefitPackage = BenefitPackage::create($request->all());
        $benefitPackage->benefits()->sync($request->input('benefits', []));
        if ($request->input('picture', false)) {
            $benefitPackage->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        return (new BenefitPackageResource($benefitPackage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BenefitPackage $benefitPackage)
    {
        abort_if(Gate::denies('benefit_package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitPackageResource($benefitPackage->load(['benefits', 'team']));
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

        return (new BenefitPackageResource($benefitPackage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BenefitPackage $benefitPackage)
    {
        abort_if(Gate::denies('benefit_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitPackage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
