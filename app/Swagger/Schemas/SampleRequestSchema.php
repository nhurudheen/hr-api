<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SampleRequestSchema",
 *     type="object",
 *     required={"name","age"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="age", type="integer", example=25),
 *     @OA\Property(property="email", type="string", example="")
 * )
 */
class SampleRequestSchema
{
    // Empty class, annotations only
}
