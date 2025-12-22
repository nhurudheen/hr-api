<?php

namespace App\Support\Validation;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QueryParamValidator
{
    public static function getRequiredParams(Request $request, array $required): array
    {
        $missing = [];
        $values = [];

        foreach ($required as $param) {
            $value = $request->query($param);
            if (is_null($value)) {
                $missing[] = $param;
            } else {
                $values[$param] = $value;
            }
        }

        if (!empty($missing)) {
            throw new HttpException(422, 'Missing required parameters: ' . implode(', ', $missing));
        }

        return $values;
    }
    public static function getOptionalParams(Request $request, array $optional): array
    {
        $values = [];

        foreach ($optional as $param) {
            $value = $request->query($param);
            if (!is_null($value) && $value !== '') {
                $values[$param] = $value;
            }
        }

        return $values;
    }
}
