<?php

namespace App\Services;

interface AccountTypeInterface {

    public function search($id, $attr);

    public function store($attr);

    public function update($id, $attr);

    public function delete($id);

}


;?>
