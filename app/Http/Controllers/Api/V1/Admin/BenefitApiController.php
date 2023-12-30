<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Http\Resources\Admin\BenefitResource;
use App\Models\Benefit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('benefit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitResource(Benefit::with(['category', 'team'])->get());
    }

    public function store(StoreBenefitRequest $request)
    {
        $benefit = Benefit::create($request->all());

        if ($request->input('picture', false)) {
            $benefit->addMedia(storage_path('tmp/uploads/' . basename($request->input('picture'))))->toMediaCollection('picture');
        }

        return (new BenefitResource($benefit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitResource($benefit->load(['category', 'team']));
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

        return (new BenefitResource($benefit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
