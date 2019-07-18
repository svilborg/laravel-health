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
     *
     * {@inheritdoc}
     * @see \Illuminate\Http\Resources\Json\ResourceCollection::toArray()
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            return new HealthCheck($item);
        })->values();
    }
}
