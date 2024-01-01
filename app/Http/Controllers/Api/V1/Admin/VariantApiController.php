<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Http\Resources\Admin\VariantResource;
use App\Models\Variant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VariantApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VariantResource(Variant::with(['benefit', 'team'])->get());
    }

    public function store(StoreVariantRequest $request)
    {
        $variant = Variant::create($request->all());

        return (new VariantResource($variant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Variant $variant)
    {
        abort_if(Gate::denies('variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VariantResource($variant->load(['benefit', 'team']));
    }

    public function update(UpdateVariantRequest $request, Variant $variant)
    {
        $variant->update($request->all());

        return (new VariantResource($variant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Variant $variant)
    {
        abort_if(Gate::denies('variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $variant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
