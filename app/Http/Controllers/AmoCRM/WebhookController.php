<?php

namespace App\Http\Controllers\AmoCRM;

use App\Http\Controllers\Controller;
use App\Jobs\AmoCRM\HandleWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request) {
        $data = $request->all();

        HandleWebhook::dispatch($data);
    }
}
