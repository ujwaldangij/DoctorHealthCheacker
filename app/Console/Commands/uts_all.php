<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class uts_all extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uts_all';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Set the source and destination folders
        $sourceFolder = public_path('temp/old/HTML5_Full_Version');
        $destinationFolder = public_path('temp/new/');

        // Ensure the destination folder exists
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0755, true);
        }

        // Get all HTML files in the source folder
        $htmlFiles = File::glob($sourceFolder . '/*.html');

        foreach ($htmlFiles as $htmlFile) {
            // Process each HTML file
            $filename = pathinfo($htmlFile, PATHINFO_BASENAME);
            $path = $sourceFolder . DIRECTORY_SEPARATOR . $filename;

            $content = file_get_contents($path);

            // Adjust the regular expression to handle different types of quotes around URLs
            $pattern = '/(href|src)=["\'](.*?)["\']/i';
            $content = preg_replace_callback($pattern, function ($matches) {
                $url = $matches[2];
                return $matches[1] . '="{{ asset(\'storage/WebsiteAsset/SuperAdmin/' . $url . '\') }}"';
            }, $content);

            // Write the modified content to the new destination folder with a .blade.php extension
            file_put_contents($destinationFolder . str_replace(".html", ".blade.php", $filename), $content);

            $this->info("Links in $filename replaced successfully!");
        }

        $this->info('All HTML files in the source folder processed successfully!');
    }
}
