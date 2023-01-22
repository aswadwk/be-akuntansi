<?php

namespace App\Services\Impl;

use App\Models\Transaction;
use App\Services\TransactionServiceInterface;

class TransactionService implements TransactionServiceInterface {

        public function store($attrs) {
            $transaction = Transaction::create($attrs);
            return $transaction;
        }

        public function show($id) {
            $transaction = Transaction::findOrFail($id);
            return $transaction;
        }

        public function generateTransactionCode() : string {
            return 'TRX-'.now()->format('ymd').'-'. $this->countDay();
        }

        public function countDay(): int {
            $count = Transaction::whereDate('created_at', now()->format('Y-m-d'))->count();
            return $count;
        }
}


;?>
