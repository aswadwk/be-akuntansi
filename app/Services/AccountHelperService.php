<?php

namespace App\Services;

interface AccountHelperService
{
    public function getAll($params);
    public function getById($accountHelperId);
    public function store($params);
    public function update($accountHelperId, $params);
    public function delete($accountHelperId);
}
