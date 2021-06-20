<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\GetUTCRequest;
use App\Services\calculationService;

class MarsDataController extends Controller
{
    protected $calculationService;

    public function __construct(calculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Get the UTC time and return msd and mtc
     * @param GetUTCRequest $getDatesRequest
     * @return JsonResponse
     */
    public function getMarsData(GetUTCRequest $getDatesRequest): JsonResponse
    {
        $convertedTime = $this->calculationService->returnValue(request('entryTime'));

        return response()->json($convertedTime);
    }

}
