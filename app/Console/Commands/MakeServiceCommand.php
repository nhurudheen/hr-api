<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new Service class inside app/Services';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $path = base_path('app/Services/' . str_replace('\\', '/', $name) . '.php');

        $className = class_basename($name);
        $namespace = 'App\\Services\\' . str_replace(
            '/',
            '\\',
            dirname(str_replace('\\', '/', $name))
        );

        if (File::exists($path)) {
            $this->error("Service already exists at {$path}");
            return;
        }

        File::ensureDirectoryExists(dirname($path));

        $template = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    public function execute(): mixed
    {
        //
    }
}
PHP;

        File::put($path, $template);

        $this->info("Service created at {$path}");
    }
}
