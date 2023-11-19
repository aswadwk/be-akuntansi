<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantError;
use App\Exceptions\NotFoundError;
use App\Models\Account;
use App\Models\AccountType;
use App\Services\AccountService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountServiceImpl implements AccountService
{
    public function search($attr, $id = null)
    {
        $code = $attr['code'] ?? null;
        $name = $attr['name'] ?? null;

        if ($id) {
            return Account::with(['accountType', 'createdBy'])
                ->find($id);
        }

        if (isset($attr['all'])) {

            return Account::with(['accountType', 'createdBy'])->get();
        }

        if ($code) {
            return Account::with(['accountType', 'createdBy'])->where('code', $code)->first();
        }

        $account = Account::with(['accountType', 'createdBy']);
        if ($name) {
            $account->where('name', 'like', '%' . $name . '%');
        }

        $account->orderBy('created_at', 'desc');

        return $account->paginate($attrs['per_page'] ?? 10);
    }

    public function store($attr)
    {
        $accountType = AccountType::find($attr['account_type_id']);

        if (!$accountType) {
            throw new NotFoundHttpException('account type tidak di temukan');
        }

        if ($this->codeIsExists($attr['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        if (!isset($attr['position_normal'])) {
            $attr['position_normal'] = $accountType->position_normal;
        }

        $attr['created_by'] = $attr['user_id'];
        unset($attr['user_id']);

        return Account::create($attr);
    }

    public function update($id, $attr)
    {
        $account = Account::find($id);

        if (empty(array_filter($attr))) {

            throw new BadRequestException(
                'Tidak ada data yang di update, pastikan anda mengirimkan data yang akan di update.'
            );
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

        if (isset($attr['balance'])) {
            $account->balance = $attr['balance'];
        }

        if (isset($attr['position_normal'])) {
            $account->position_normal = $attr['position_normal'];
        }

        if (isset($attr['account_type_id'])) {
            if (!AccountType::find($attr['account_type_id'])) {
                throw new NotFoundHttpException('Tipe akun tidak di temukan.');
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
