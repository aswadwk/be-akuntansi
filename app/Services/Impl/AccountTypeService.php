<?php

namespace App\Services\Impl;

use App\Models\AccountType;
use App\Services\AccountTypeInterface;
use Illuminate\Validation\ValidationException;

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
        if($this->codeIsExists($attr['code']))

            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);

        return AccountType::create($attr);
    }

    public function update($id, $attr)
    {
        $accountType = AccountType::find($id);

        if($accountType){
            $accountType->update($attr);

            return $accountType;
        }

        return false;
    }

    public function delete($id)
    {
        $accountType = AccountType::find($id);

        if($accountType){
            $accountType->delete();

            return $accountType;
        }

        return false;
    }

    public function codeIsExists($code):bool{
        return AccountType::where('code', $code)->exists();
    }
}


;?>
