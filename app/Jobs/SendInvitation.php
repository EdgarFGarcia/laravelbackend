<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInvitation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    protected $hasheddata;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $hasheddata)
    {
        //
        $this->email = $email;
        $this->hasheddata = $hasheddata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        app('App\Http\Controllers\ApiController')->sendinvitation($this->email, $this->hasheddata);
    }
}
