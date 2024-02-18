<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViewFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gf{filename : The name of the file} {folder? : The name of the folder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $folder = $this->argument('folder');
        $viewPath = resource_path("views/$folder");

        if (!File::isDirectory($viewPath)) {
            File::makeDirectory($viewPath, 0755, true);
        }

        $filePath = "$viewPath/$filename.blade.php";

        if (File::exists($filePath)) {
            $this->error("File $filename.blade.php already exists in $folder.");
            return;
        }

        File::put($filePath, '');

        $this->info("File $filename.blade.php created in $folder.");
    }
}
