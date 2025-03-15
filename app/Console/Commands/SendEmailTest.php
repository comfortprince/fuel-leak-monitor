<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Alert;
use App\Mail\FuelLeakAlert;

class SendEmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alert = Alert::find(5);

        // $email = $alert->customAlert->storageTank->user->email;
        $email = "comfort.prince.hluyo@gmail.com";

        Mail::to($email)->send(new FuelLeakAlert($alert));

    }
}
