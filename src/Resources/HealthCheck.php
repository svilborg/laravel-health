<?php
namespace Health\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Health Check Resource
 *
 * @method string getName()
 * @method string getState()
 * @method array getData()
 */
class HealthCheck extends JsonResource
{

    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'status' => $this->getState(),
            'data' => $this->getData()
        ];
    }
}
