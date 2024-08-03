<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;


#[OA\SecurityScheme(
    securityScheme: "basicAuth",
    type: "http",
    scheme: "basic"

)]

class OpenApiConfig
{

}