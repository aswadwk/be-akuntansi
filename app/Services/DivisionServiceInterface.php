<?php

namespace App\Services;

interface DivisionServiceInterface
{
    public function store($attrs);

    public function update($id, $attrs);

    public function delete($id);

    public function show($id);

    public function search($id, $attrs);
}


;
