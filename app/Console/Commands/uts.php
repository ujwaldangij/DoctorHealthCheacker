<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class uts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uts {filename? : pass file name}{folder? : pass folder name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $foldername = $this->argument('folder');
        $path = public_path($foldername . "\\" . $filename);
        $this->info($path);
        if (!file_exists($path)) {
            return $this->error('File not found');
        }
        $content = file_get_contents($path);
        $pattern = '/(href|src)=["\'](.*?)["\']/i';
        $content = preg_replace_callback($pattern, function ($matches) {
            $url = $matches[2];
            return $matches[1] . '="{{ asset(\'storage/WebsiteAsset/SuperAdmin/' . $url . '\') }}"';
        }, $content);

        file_put_contents(public_path('temp/new/'.str_replace("html","blade.php",$filename)), $content);
        $this->info("Links in $filename replaced successfully!");
    }
}
