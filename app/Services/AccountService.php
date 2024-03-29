<?php

namespace App\Services;

interface AccountService
{
    public function search($attr, $id = null);

    public function store($attr);

    public function update($id, $attr);

    public function delete($id);
};
