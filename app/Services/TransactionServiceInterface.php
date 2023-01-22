<?php

namespace App\Services;

interface TransactionServiceInterface {

    public function generateTransactionCode() : string;

    public function store($attrs);

    public function show($id);

    public function countDay(): int;
}


;?>
