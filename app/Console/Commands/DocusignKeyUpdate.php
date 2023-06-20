<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\DocusignController;
use Exception;
use Illuminate\Support\Facades\Log;

class DocusignKeyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Docusign access token';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {  
        Log::info('Starting DocusignKeyUpdate command.');
        try {
            (new DocusignController)->refreshToken();

            Log::info('DocusignKeyUpdate command completed successfully.');
        } catch (Exception $e) {
            Log::error('Error executing DocusignKeyUpdate command: ' . $e->getMessage());
        }
        
    }
}
