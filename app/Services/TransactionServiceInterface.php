<?php

namespace App\Services;

interface TransactionServiceInterface {

    public function getAllTransactions();

    public function generateTransactionCode() : string;

    public function store($attrs);

    public function getTransactionById($id);

    public function update($attrs, $id);

    public function countDay(): int;
}


;?>
