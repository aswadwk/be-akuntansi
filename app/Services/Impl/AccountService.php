<?php

namespace App\Services\Impl;

use App\Models\Account;
use App\Services\AccountService as AccountServiceInterface;
use Illuminate\Validation\ValidationException;

class AccountService implements AccountServiceInterface{

    public function search($id=null, $attr){

        $code = $attr['code'] ?? null;
        $name = $attr['name'] ?? null;

        if($id){
            return Account::find($id);
        }

        if($code){
            return Account::where('code', $code)->first();
        }

        $account = Account::query();
        if($name)
            $account->where('name', 'like', '%'.$name.'%');

        return $account->get();
    }

    public function store($attr)
    {
        if($this->codeIsExists($attr['code']))

            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);

        return Account::create($attr);
    }

    public function update($id, $attr)
    {
        $account = Account::find($id);

        if($this->codeIsExists($attr['code'], $id))

            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);

        if($account){
            $account->update($attr);

            return $account;
        }

        return false;
    }

    public function delete($id)
    {
        $account = Account::find($id);

        if($account){
            $account->delete();

            return $account;
        }

        return false;
    }

    public function codeIsExists($code, $id=null):bool{

        $account = Account::query();
        if($id){
            $account->where('id','!=', $id);
        }

        return $account->where('code', $code)
            ->exists();
    }
}


;?>
