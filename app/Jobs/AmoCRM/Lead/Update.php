<?php

namespace App\Jobs\AmoCRM\Lead;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Update implements ShouldQueue
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
    public function handle(): void
    {
        $config = config('services.amocrm.leads');
        $data = $this->data;

        $lead = Lead::query()->where('amocrm_id', $data['id'])->first();

        $price = $data['price'] ?? 0;

        $profit = $this->getCustomField($data, $config['profit_id']);

        $primeCost = $this->getCustomField($data, $config['prime_cost_id']);

        Log::info(json_encode([
            'price' => $price,
            'profit' => $profit,
            'primeCost' => $primeCost
        ]));

    }

    public function getCustomField($lead, $id) {
        $customFields = collect($lead['custom_fields'] ?? []);
        $customField = $customFields->firstWhere('id', $id);

        if (!$customField) {
            return null;
        }

        return $customField['values'][0]['value'];
    }
}
