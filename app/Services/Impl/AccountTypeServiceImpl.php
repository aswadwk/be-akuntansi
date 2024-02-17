<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantError;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\ProfitLossAccount;
use App\Services\AccountTypeService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AccountTypeServiceImpl implements AccountTypeService
{
    public function search($attrs, $id = null)
    {
        $code = $attrs['code'] ?? null;
        $name = $attrs['name'] ?? null;

        if ($id) {
            return AccountType::with('createdBy')->find($id);
        }

        if (isset($attrs['all'])) {

            return AccountType::with('createdBy')->get();
        }

        if ($code) {
            return AccountType::with('createdBy')->where('code', $code)->first();
        }

        $accountType = AccountType::with('createdBy');

        if ($name) {
            $accountType->where('name', 'like', '%' . $name . '%');
        }

        $accountType->orderBy('created_at', 'desc');

        return $accountType->paginate($attrs['per_page'] ?? 10);
    }

    public function store($attrs)
    {
        if ($this->codeIsExists($attrs['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        $attrs['created_by'] = $attrs['user_id'];
        unset($attrs['user_id']);

        return AccountType::create($attrs);
    }

    public function update($id, $attr)
    {
        if (empty(array_filter($attr))) {
            throw new BadRequestException(
                'Tidak ada data yang di update, pastikan anda mengirimkan data yang akan di update'
            );
        }

        $accountType = AccountType::find($id);

        if (isset($attr['code'])) {
            if ($this->codeIsExists($attr['code'], $id)) {
                throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
            }

            $accountType->code = $attr['code'];
        }

        if (isset($attr['name'])) {
            $accountType->name = $attr['name'];
        }

        if (isset($attr['position_normal'])) {
            $accountType->position_normal = $attr['position_normal'];
        }

        if (isset($attr['description'])) {
            $accountType->description = $attr['description'];
        }

        return $accountType->save();
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

    public function addProfitLossAccount($accountTypeId)
    {
        $accountType = AccountType::find($accountTypeId);

        if ($accountType) {
            $accountType->profitLossAccount()->create([
                'account_type_id' => $accountTypeId,
            ]);

            return $accountType;
        }

        return false;
    }

    public function removeProfitLossAccount($profitLossAccountId)
    {
        $profitLossAccount = ProfitLossAccount::find($profitLossAccountId);

        if ($profitLossAccount) {
            $profitLossAccount->delete();

            return $profitLossAccount;
        }

        return false;
    }

    public function getProfitLossAccounts()
    {
        return AccountType::with('profitLossAccount')
            ->whereHas('profitLossAccount')
            ->get();
    }
};
