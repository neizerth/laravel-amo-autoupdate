<?php

namespace App\Components;

use AmoCRM\Client\AmoCRMApiClient;

class AmoCRM {
    public static function getClient() {
        $config = config('services.amocrm.client');
        $clientId = $config['client_id'];
        $clientSecret = $config['client_secret'];
        $redirectUri = $config['redirect_uri'];
        $code = $config['code'];

        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
    }
}
