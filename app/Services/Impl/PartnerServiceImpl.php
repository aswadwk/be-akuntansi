<?php

namespace App\Services\Impl;

use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartnerServiceImpl implements PartnerService
{
    public function search($parnerId, $attrs)
    {
        if ($parnerId) {
            $partner = Partner::find($parnerId);

            if ($partner) {
                return $partner;
            }

            throw new NotFoundHttpException('parner tidak di temukan');
        }

        $parners = Partner::query();

        if (isset($attrs['name'])) {
            $parners->where('name', 'like', "%{$attrs['name']}%");
        }

        if (isset($attrs['all']) && $attrs['all'] == true) {
            return $parners->get();
        }

        return $parners->paginate($attrs['per_page'] ?? 10);
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

        if (empty(array_filter($attrs))) {
            throw new BadRequestHttpException('tidak ada data yang di ubah');
        }

        if (isset($attrs['code'])) {

            if ($this->codeIsExists($attrs['code'], $id)) {
                throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
            }
        }

        if (isset($attrs['user_id'])) {
            $partner->user_id = $attrs['user_id'];
        }

        if (isset($attrs['code'])) {
            $partner->code = $attrs['code'];
        }

        if (isset($attrs['name'])) {
            $partner->name = $attrs['name'];
        }

        if (isset($attrs['type'])) {
            $partner->type = $attrs['type'];
        }

        if (isset($attrs['description'])) {
            $partner->type = $attrs['description'];
        }

        $partner->save();
    }

    public function delete($id)
    {
        $partner = Partner::find($id);

        if ($partner) {
            $partner->delete();

            return $partner;
        }

        throw new NotFoundHttpException('parner tidak di temukan');
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
};
