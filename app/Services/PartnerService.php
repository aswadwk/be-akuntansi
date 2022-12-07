<?php

namespace App\Services;

interface PartnerService{

    public function get();

    public function getById($id);

    public function store($attr);

    public function update($id, $attr);

    public function delete($id);
}

;?>
