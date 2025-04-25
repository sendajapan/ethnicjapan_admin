<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $baseUrl;

    public function __construct(){
        $this->baseUrl = 'https://senda.us/karmen/new/page_include/shipment_manage/';
    }

    public function getBookingData($bookingId)
    {
        $response = Http::get("{$this->baseUrl}/booking_details_json.php", [
            'id' => $bookingId
        ]);

        return json_decode($response->body(), false);
    }

}
