<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SampleRequest;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;

class GeneralController extends Controller
{
    use JsonResponseTrait;

    public function index(): JsonResponse
    {
        return $this->successResponse(message: 'PING Successful');
    }

    public function statusQuote(SampleRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successResponse(message: 'Status Working Successful'.$data['name']);
    }

}
