<?php
namespace Health\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * HealthCheck Collection
 */
class HealthCheckCollection extends ResourceCollection
{

    /**
     *
     * @param array $resource
     */
    public function __construct($resource)
    {
        parent::__construct(collect($resource));
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            return new HealthCheck($item);
        })->values();
    }
}