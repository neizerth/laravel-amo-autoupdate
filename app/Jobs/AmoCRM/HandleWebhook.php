<?php

namespace App\Jobs\AmoCRM;

use App\Jobs\AmoCRM\Lead\Update as UpdateLead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class HandleWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
//        Log::info(json_encode($this->data));

        if (empty($this->data['leads'])) {
            return;
        }

        $leads = [];

        if (!empty($this->data['leads']['add'])) {
            $leads = $this->data['leads']['add'];
        }
        if (!empty($this->data['leads']['update'])) {
            $leads = $this->data['leads']['update'];
        }

        foreach ($leads as $lead) {
            return UpdateLead::dispatch($lead);
        }
    }
}
