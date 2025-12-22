<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDtoCommand extends Command
{
    protected $signature = 'make:dto {name}';
    protected $description = 'Create a new DTO class inside app/DTO';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $path = base_path('app/DTO/' . str_replace('\\', '/', $name) . '.php');

        $className = class_basename($name);
        $namespace = 'App\\DTO\\' . str_replace('/', '\\', dirname(str_replace('\\', '/', $name)));

        if (File::exists($path)) {
            $this->error("DTO already exists at {$path}");
            return;
        }

        File::ensureDirectoryExists(dirname($path));

        $template = <<<PHP
<?php

namespace {$namespace};

readonly class {$className}
{
    public function __construct(

    ) {
    }

    public function toArray(): array
    {
        return [

        ];
    }
}
PHP;

        File::put($path, $template);
        $this->info("DTO created at {$path}");
    }
}
