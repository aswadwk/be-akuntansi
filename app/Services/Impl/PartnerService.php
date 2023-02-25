<?php

namespace App\Services\Impl;

use App\Exceptions\NotFoundError;
use App\Models\Partner;
use App\Services\PartnerService as PartnerServiceInterface;
use Illuminate\Validation\ValidationException;

class PartnerService implements PartnerServiceInterface
{
    public function get()
    {
        return Partner::all();
    }

    public function getById($id)
    {
        return Partner::find($id);
    }

    public function store($attr)
    {
        if ($this->codeIsExists($attr['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        return Partner::create($attr);
    }

    public function update($id, $attrs)
    {
        $partner = Partner::find($id);

        if ($this->codeIsExists($attrs['code'], $id)) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        if ($partner) {
            $partner->update($attrs);

            return $partner;
        }

        throw new NotFoundError('parner tidak di temukan');
    }

    public function delete($id)
    {
        $partner = Partner::find($id);

        if ($partner) {
            $partner->delete();

            return $partner;
        }

        throw new NotFoundError('parner tidak di temukan');
    }

    public function codeIsExists($code, $id = null): bool
    {
        $account = Partner::query();
        if ($id) {
            $account->where('id', '!=', $id);
        }

        return $account->where('code', $code)
            ->exists();
    }
}


;
