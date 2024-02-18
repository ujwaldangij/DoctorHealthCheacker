<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class log extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log';

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
        // foreach (range(1,100) as $key => $value) {
        //     $response = Http::get('https://thewhatsappmarketing.com/api/send', [
        //         'number' => '91808',
        //         'type' => 'text',
        //         'message' => 'kaisa hai lavde',
        //         'instance_id' => '65B654523DFFD',
        //         'access_token' => '65742a6cedff6',
        //     ]);
        // }
        // return Command::SUCCESS;
    }
}
