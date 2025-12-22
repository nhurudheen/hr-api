<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ReflectionClass;

class MakeSwaggerSchema extends Command
{
    protected $signature = 'make:schema {path}';
    protected $description = 'Generate Swagger schema from FormRequest with optional folder and realistic examples';

    public function handle()
    {
        $pathArg = $this->argument('path');

        // Split folder and class
        if (str_contains($pathArg, '/')) {
            [$folder, $requestClass] = explode('/', $pathArg, 2);
        } else {
            $folder = '';
            $requestClass = $pathArg;
        }

        // Convert forward slashes to backslashes for PHP namespace
        $requestClass = str_replace('/', '\\', $requestClass);

        if (!class_exists($requestClass)) {
            $this->error("Request class {$requestClass} does not exist.");
            return 1;
        }

        $reflection = new ReflectionClass($requestClass);
        $instance = $reflection->newInstanceWithoutConstructor();
        $rules = $instance->rules();

        $properties = [];
        $required = [];

        foreach ($rules as $field => $ruleArray) {
            $type = 'string'; // default
            $example = '""';

            foreach ($ruleArray as $rule) {
                if (str_contains($rule, 'integer')) {
                    $type = 'integer';
                    $example = 25;
                } elseif (str_contains($rule, 'boolean')) {
                    $type = 'boolean';
                    $example = true;
                } elseif (str_contains($rule, 'string')) {
                    $type = 'string';
                    // Generate a friendly example based on field name
                    if (str_contains(strtolower($field), 'name')) {
                        $example = '"John Doe"';
                    } elseif (str_contains(strtolower($field), 'email')) {
                        $example = '"john@example.com"';
                    } elseif (str_contains(strtolower($field), 'phone')) {
                        $example = '"08012345678"';
                    } else {
                        $example = '"Sample text"';
                    }
                }
            }

            $properties[] = " *     @OA\Property(property=\"{$field}\", type=\"{$type}\", example={$example})";

            if (in_array('required', $ruleArray)) {
                $required[] = $field;
            }
        }

        $requiredLine = !empty($required) ? 'required={"'.implode('","',$required).'"}' : '';

        $schemaName = class_basename($requestClass).'Schema';

        // Generate final content
        $content = "<?php\n\nnamespace App\\Swagger\\Schemas";
        if ($folder) {
            $content .= "\\{$folder}";
        }
        $content .= ";\n\nuse OpenApi\Annotations as OA;\n\n/**\n";
        $content .= " * @OA\Schema(\n";
        $content .= " *     schema=\"{$schemaName}\",\n";
        $content .= " *     type=\"object\",\n";
        if ($requiredLine) {
            $content .= " *     {$requiredLine},\n";
        }
        $content .= implode(",\n", $properties) . "\n";
        $content .= " * )\n */\n";
        $content .= "class {$schemaName}\n{\n    // Empty class, annotations only\n}\n";

        // Create folder if it doesn't exist
        $dir = app_path('Swagger/Schemas' . ($folder ? "/{$folder}" : ""));
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filePath = $dir.'/'.$schemaName.'.php';
        file_put_contents($filePath, $content);

        $this->info("Schema created at {$filePath}");
        return 0;
    }
}
