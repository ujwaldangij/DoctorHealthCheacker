<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ss';

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
        $response = Http::get('https://thewhatsappmarketing.com/api/send', [
            'number' => '917738605499',
            'type' => 'text',
            'message' => 'Dear Doctor, Please take your today\'s medicine',
            'instance_id' => '65B654523DFFD',
            'access_token' => '65742a6cedff6',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->info('WhatsApp message sent successfully!');
            // Process the API response data if needed
        } else {
            $error = $response->json();
            $this->error('Failed to send WhatsApp message. Error: ' . json_encode($error));
        }
    }
}
