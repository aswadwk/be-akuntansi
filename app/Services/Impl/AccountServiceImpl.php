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
    public function search($params, $id = null)
    {
        if ($id) {
            return Account::with(['accountType', 'createdBy'])
                ->find($id);
        }

        if (isset($params['all'])) {

            return Account::with(['accountType', 'createdBy'])->get();
        }

        /** @disregard */
        return  Account::with(['accountType', 'createdBy'])
            ->orderBy($params['order_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->when(isset($params['code']), function ($query) use ($params) {
                return $query->where('code', $params['code']);
            })
            ->when(isset($params['name']), function ($query) use ($params) {
                return $query->where('name', 'like', '%' . $params['name'] . '%');
            })
            ->paginate($params['per_page'] ?? 10)
            ->withQueryString();
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

        if (isset($attr['opening_balance'])) {
            $account->opening_balance = $attr['opening_balance'];
        }

        if (isset($attr['position_normal'])) {
            $account->position_normal = $attr['position_normal'];
        }

        if (isset($attr['position_report'])) {
            $account->position_report = $attr['position_report'];
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
