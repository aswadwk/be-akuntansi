<?php

namespace App\Services;

interface JournalServiceInterface {

    public function store($attrs);

    public function generateJournalCode($num);

}


;?>
