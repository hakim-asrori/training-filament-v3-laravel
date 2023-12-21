<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EnumCommand extends Command
{
    protected $basePath = 'App\Enums';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {class : The name of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new a enum class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filter = $this->argument('class');

        if ($filter === '' || is_null($filter) || empty($filter)) {
            $this->error('filter name invalid..!');
        }

        if (!File::exists($this->getBaseDirectory($filter))) {
            File::makeDirectory($this->getBaseDirectory($filter), 0775, true);
        }

        $title = Str::remove(' ', ucwords(Str::of($filter)->replace('_', ' ')));
        $baseName = $this->getBaseFileName($filter);

        $filterPath = 'app/Enums/' . $title;
        $filePath = $filterPath . '.php';
        $filterNameSpacePath = $this->getNameSpacePath($this->getNameSpace($filterPath));

        if (!File::exists($filePath)) {
            $eloquentFileContent = "<?php\n\nnamespace " . $filterNameSpacePath . ";\n\nclass " . $baseName . "\n{\n\t\n}";

            File::put($filePath, $eloquentFileContent);

            $this->info('filter created successfully...!');
        } else {
            $this->error('filter already exist...!');
        }
    }

    protected function getBaseDirectory($className)
    {
        return File::dirname($this->basePath . '\\' . $className);
    }

    protected function getBaseFileName($className)
    {
        return class_basename(Str::ucfirst($className));
    }

    protected function getNameSpacePath($factoryName)
    {
        $chunks = explode("\\", $factoryName);
        $fileName = collect($chunks)->last();

        return Str::ucfirst(str_replace('\\' . $fileName, '', $factoryName));
    }

    protected function getNameSpace($factoryName)
    {
        return str_replace('/', '\\', $factoryName);
    }
}
