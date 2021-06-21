<?php

namespace App\Http\Controllers;

use App\Services\marsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\GetUTCRequest;

class MarsDataController extends Controller
{
    protected $marsService;

    public function __construct(marsService $marsService)
    {
        $this->marsService = $marsService;
    }

    /**
     * Get the UTC time and return msd and mtc
     * @Get("/mars-data?{$utcDateTime}, where={"utcDateTime": "Y-m-d H:i:s"}")
     * @param GetUTCRequest $getDatesRequest
     * @return JsonResponse
     */
    public function index(GetUTCRequest $getDatesRequest): JsonResponse
    {
        $convertedTime = $this->marsService->marsData(request('entryTime'));

        return response()->json($convertedTime);
    }

}
