<?php

namespace Faakolore\USSD\Observers;


use Faakolore\USSD\Models\HistoricalTransactionTrail;
use Faakolore\USSD\Models\TransactionTrail;

class TransactionTrailObserver
{
    /**
     * Handle the transaction trail "created" event.
     *
     * @param TransactionTrail $transactionTrail
     * @return void
     */
    public function created(TransactionTrail $transactionTrail)
    {
        $this->createHistoricalRecord($transactionTrail);
    }

    /**
     * Handle the transaction trail "updated" event.
     *
     * @param TransactionTrail $transactionTrail
     * @return void
     */
    public function updated(TransactionTrail $transactionTrail)
    {
        $this->createHistoricalRecord($transactionTrail);
    }

    /**
     * @param TransactionTrail $transactionTrail
     */
    private function createHistoricalRecord(TransactionTrail $transactionTrail): void
    {
        HistoricalTransactionTrail::updateOrCreate(['id' => $transactionTrail->getKey()],
            $transactionTrail->only(['session_id', 'message', 'response'])
        );
    }

}
