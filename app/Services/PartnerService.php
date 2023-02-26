<?php

namespace App\Services;

interface PartnerService
{
    public function search($parnerId, $attrs);

    public function store($attr);

    public function update($id, $attr);

    public function delete($id);
}

;
