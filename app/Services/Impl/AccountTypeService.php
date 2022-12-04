<?php

namespace App\Services\Impl;

use App\Models\AccountType;
use App\Services\AccountTypeInterface;

class AccountTypeService implements AccountTypeInterface{

    public function search($id=null, $attr){

        $code = $attr['code'] ?? null;
        $name = $attr['name'] ?? null;

        if($id){
            return AccountType::find($id);
        }

        if($code){
            return AccountType::where('code', $code)->first();
        }

        $accountType= AccountType::query();
        if($name)
            $accountType->where('name', 'like', '%'.$name.'%');

        return $accountType->get();
    }

    public function store($attr)
    {
        return AccountType::create($attr);
    }
}


;?>
