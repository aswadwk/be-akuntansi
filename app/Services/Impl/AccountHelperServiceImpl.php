<?php

namespace App\Services\Impl;

use App\Models\AccountHelper;
use App\Services\AccountHelperService;
use Illuminate\Validation\ValidationException;

class AccountHelperServiceImpl implements AccountHelperService
{
    public function getAll($params)
    {
        return AccountHelper::paginate($params['limit'] ?? 10);
    }

    public function getById($accountHelperId)
    {
        return AccountHelper::find($accountHelperId);
    }

    public function store($params)
    {
        // check if code already exists
        $codeExists = AccountHelper::where('code', $params['code'])->exists();

        if ($codeExists) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        $params['created_by'] = auth()->id();
        return AccountHelper::create($params);
    }

    public function update($accountHelperId, $params)
    {
        $accountHelper = AccountHelper::find($accountHelperId);

        // check if code already exists
        $codeExists = AccountHelper::where('code', $params['code'])
            ->where('id', '!=', $accountHelperId)
            ->exists();

        if ($codeExists) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        if ($accountHelper) {
            $accountHelper->update($params);
        }

        return $accountHelper;
    }

    public function delete($accountHelperId)
    {
        $accountHelper = AccountHelper::find($accountHelperId);

        if ($accountHelper) {
            $accountHelper->delete();
        }

        return $accountHelper;
    }
}
