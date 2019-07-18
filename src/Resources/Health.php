<?php
namespace Health\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Health Resource
 */
class Health extends JsonResource
{

    public function toArray($request)
    {
        return [
            'status' => $this->getState(),
            'checks' => new HealthCheckCollection($this->getChecks())
        ];
    }
}
