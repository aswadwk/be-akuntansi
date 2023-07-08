<?php

namespace App\Services;

interface JournalServiceInterface
{
    public function store($attrs);

    public function generateJournalCode($num);

    public function getJournalByTransactionId($transactionId);

    public function getJournals($params);

    public function updateJournal($params, $transactionId);
};
