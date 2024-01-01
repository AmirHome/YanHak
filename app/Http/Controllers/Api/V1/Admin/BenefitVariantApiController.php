<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBenefitVariantRequest;
use App\Http\Requests\UpdateBenefitVariantRequest;
use App\Http\Resources\Admin\BenefitVariantResource;
use App\Models\BenefitVariant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitVariantApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('benefit_variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitVariantResource(BenefitVariant::with(['benefit', 'team'])->get());
    }

    public function store(StoreBenefitVariantRequest $request)
    {
        $benefitVariant = BenefitVariant::create($request->all());

        if ($request->input('picture', false)) {
            $benefitVariant->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        return (new BenefitVariantResource($benefitVariant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BenefitVariant $benefitVariant)
    {
        abort_if(Gate::denies('benefit_variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitVariantResource($benefitVariant->load(['benefit', 'team']));
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

        return (new BenefitVariantResource($benefitVariant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BenefitVariant $benefitVariant)
    {
        abort_if(Gate::denies('benefit_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitVariant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
