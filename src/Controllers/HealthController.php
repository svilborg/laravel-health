<?php
namespace Health\Controllers;

use Illuminate\Routing\Controller;
use Health\Services\HealthService;
use Symfony\Component\HttpFoundation\Request;
use Health\Resources\Health;

/**
 * Health Check Controler
 */
class HealthController extends Controller
{

    /**
     *
     * @var HealthService
     */
    private $healthService;

    /**
     *
     * @param HealthService $healthService
     */
    public function __construct(HealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    /**
     *
     * @param Request $request
     * @return Health
     */
    public function check(Request $request)
    {
        $health = $this->healthService->getHealth(config('health'));

        $response = new Health($health);
        $response->withoutWrapping();

        return $response->response()->setStatusCode(503);
    }
}