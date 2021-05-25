<?php

namespace Mi\Core\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren.minimum)
 */
class BaseCollection extends ResourceCollection
{
    /**
     * @var string|null
     */
    protected $resourceName = null;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'current_page' => $this->resource->currentPage(),
                'data' => $this->getResourceClass()::collection($this->resource->getCollection()),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ];
        }

        return [
            'data' => $this->getResourceClass()::collection($this->resource)
        ];
    }

    /**
     * Get resource class name from collection
     *
     * @return string
     */
    protected function getResourceClass()
    {
        return $this->resourceName ?? Str::replaceLast('Collection', 'Resource', get_class($this));
    }
}
