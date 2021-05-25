<?php

namespace App\Domain\Shared\Resources;

use App\Domain\Shared\Resources\ResourceResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
class BaseResource extends JsonResource
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
