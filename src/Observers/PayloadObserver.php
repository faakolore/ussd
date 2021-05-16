<?php

namespace Faakolore\USSD\Observers;

use Faakolore\USSD\Models\HistoricalPayload;
use Faakolore\USSD\Models\Payload;

class PayloadObserver
{
    public function created(Payload $payload)
    {
        $this->createHistoricalRecord($payload);
    }

    public function updated(Payload $payload)
    {
        $this->createHistoricalRecord($payload);
    }

    private function createHistoricalRecord(Payload $payload): void
    {
        HistoricalPayload::updateOrCreate(['id' => $payload->getKey()], $payload->only(['session_id', 'key', 'value']));
    }
}
