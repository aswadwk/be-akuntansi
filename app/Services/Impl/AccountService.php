<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantError;
use App\Exceptions\NotFoundError;
use App\Models\Account;
use App\Models\AccountType;
use App\Services\AccountService as AccountServiceInterface;
use Illuminate\Validation\ValidationException;

class AccountService implements AccountServiceInterface
{
    public function search($id = null, $attr)
    {
        $code = $attr['code'] ?? null;
        $name = $attr['name'] ?? null;

        if ($id) {
            return Account::find($id);
        }

        if (isset($attr['all'])) {

            return Account::get();
        }

        if ($code) {
            return Account::where('code', $code)->first();
        }

        $account = Account::query();
        if ($name) {
            $account->where('name', 'like', '%' . $name . '%');
        }

        $account->orderBy('created_at', 'desc');

        return $account->paginate($attrs['per_page'] ?? 10);
    }

    public function store($attr)
    {
        if ($this->codeIsExists($attr['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        return Account::create($attr);
    }

    public function update($id, $attr)
    {
        $account = Account::find($id);

        if (empty(array_filter($attr))) {
            throw new InvariantError('tidak ada data yang di update, pastikan anda mengirimkan data yang akan di update');
        }

        if (isset($attr['code'])) {
            if ($this->codeIsExists($attr['code'], $id)) {
                throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
            }

            $account->code = $attr['code'];
        }

        if (isset($attr['name'])) {
            $account->name = $attr['name'];
        }

        if (isset($attr['description'])) {
            $account->description = $attr['description'];
        }

        if (isset($attr['account_type_id'])) {
            if (!AccountType::find($attr['account_type_id'])) {
                throw new NotFoundError('account type tidak di temukan');
            }

            $account->account_type_id = $attr['account_type_id'];
        }

        $account->save();
    }

    public function delete($id)
    {
        $account = Account::find($id);

        if ($account) {
            $account->delete();

            return $account;
        }

        return false;
    }

    public function codeIsExists($code, $id = null): bool
    {
        $account = Account::query();
        if ($id) {
            $account->where('id', '!=', $id);
        }

        return $account->where('code', $code)
            ->exists();
    }
};
