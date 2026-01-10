<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RorkebController extends Controller
{
    use JsonResponseTrait;
    public function home(): JsonResponse
    {
        return $this->successResponse("Laragon Ni Me");
    }
}
