<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TargetPCController;

class CheckPCs extends Command
{
    protected $signature = 'check:pcs';
    protected $description = 'Check and control added PCs automatically';

    public function handle()
    {
        (new TargetPCController)->checkAndControl();
    }
}
