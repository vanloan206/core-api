<?php

namespace App\Domain\Shared\Resources;

use App\Domain\Shared\Resources\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
class BaseCollection extends ResourceCollection
{
    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }
}
