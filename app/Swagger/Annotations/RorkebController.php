<?php

namespace App\Swagger\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     summary="Ror",
 *     path="/api/v1/utility/xyz",
 *     tags={"Rorkeb Endpoint"},
 *     @OA\Response(response=200, description="Success")
 * )
 * */
class RorkebController
{
}
