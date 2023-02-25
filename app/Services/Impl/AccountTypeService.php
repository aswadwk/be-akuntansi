<?php

namespace App\Services\Impl;

use App\Models\AccountType;
use App\Services\AccountTypeInterface;
use Illuminate\Validation\ValidationException;

class AccountTypeService implements AccountTypeInterface
{
    public function search($id = null, $attrs)
    {
        $code = $attrs['code'] ?? null;
        $name = $attrs['name'] ?? null;

        if ($id) {
            return AccountType::with('createdBy')->find($id);
        }

        if ($code) {
            return AccountType::with('createdBy')->where('code', $code)->first();
        }

        $accountType = AccountType::with('createdBy');

        if ($name) {
            $accountType->where('name', 'like', '%'.$name.'%');
        }

        $accountType->orderBy('created_at', 'desc');

        return $accountType->paginate($attrs['per_page'] ?? 10);
    }

    public function store($attrs)
    {
        if ($this->codeIsExists($attrs['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        return AccountType::create($attrs);
    }

    public function update($id, $attr)
    {
        $accountType = AccountType::find($id);

        if ($this->codeIsExists($attr['code'], $id)) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        if ($accountType) {
            $accountType->update($attr);

            return $accountType;
        }

        return false;
    }

    public function delete($id)
    {
        $accountType = AccountType::find($id);

        if ($accountType) {
            $accountType->delete();

            return $accountType;
        }

        return false;
    }

    public function codeIsExists($code, $id = null): bool
    {
        $account = AccountType::query();
        if ($id) {
            $account->where('id', '!=', $id);
        }

        return $account->where('code', $code)
            ->exists();
    }
}


;
