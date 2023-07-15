<?php

namespace App\Services;

interface AccountTypeService
{
    public function search($attr, $id = null);

    public function store($attr);

    public function update($id, $attr);

    public function delete($id);

    public function addProfitLossAccount($attr);

    public function removeProfitLossAccount($attr);

    public function getProfitLossAccounts();
};
