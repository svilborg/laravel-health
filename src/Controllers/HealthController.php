<?php
namespace Health\Controllers;

use Illuminate\Routing\Controller;
use Health\Services\HealthService;
use Symfony\Component\HttpFoundation\Request;
use Health\Resources\Health;
use Illuminate\Http\Response;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $health = $this->healthService->getHealth(config('health.checks', []));

        $statusCode = $health->isOk() ? Response::HTTP_OK : Response::HTTP_SERVICE_UNAVAILABLE;

        $response = new Health($health);
        $response->withoutWrapping();

        return $response->response()->setStatusCode($statusCode);
    }
}