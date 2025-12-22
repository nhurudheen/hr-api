<?php

namespace App\Swagger\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/v1/utility/ping",
 *     tags={"General Endpoint"},
 *     @OA\Response(response=200, description="Success")
 * )
 *
 * @OA\Post(
 *     path="/api/v1/utility/status-quote",
 *     tags={"General Endpoint"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/SampleRequestSchema")
 *     ),
 *     @OA\Response(response=200, description="Success")
 * )
 */
class GeneralController
{
    // Empty class, annotations only
}
