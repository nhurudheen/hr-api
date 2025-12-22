<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * Global API info and security
 *
 * @OA\Info(
 *     title="HR API",
 *     version="1.0",
 *     description="API documentation for HR API"
 * )
 *
 * @OA\Server(url=L5_SWAGGER_CONST_HOST)
 *
 * @OA\SecurityScheme(
 *     securityScheme="x-api-key",
 *     type="apiKey",
 *     in="header",
 *     name="x-api-key"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="Bearer Token",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApi {}
