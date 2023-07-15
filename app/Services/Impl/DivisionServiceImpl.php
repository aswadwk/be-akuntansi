<?php

namespace App\Services\Impl;

use App\Exceptions\NotFoundError;
use App\Models\Division;
use App\Services\DivisionService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DivisionServiceImpl implements DivisionService
{
    public function search($id = null, $attrs)
    {
        if ($id) {
            return Division::find($id);
        }

        if (isset($attrs['all']) && $attrs['all'] == true) {

            return Division::get();
        }

        $division = Division::query();

        if (isset($name)) {
            $division->where('name', 'like', '%' . $name . '%');
        }

        return $division->paginate($attrs['per_page'] ?? 10);
    }

    public function store($attrs)
    {
        if ($this->codeIsExists($attrs['code'])) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        return Division::create($attrs);
    }

    public function update($id, $attrs)
    {
        $division = Division::find($id);

        if ($this->codeIsExists($attrs['code'], $id)) {
            throw ValidationException::withMessages(['code' => 'Kode tidak tersedia']);
        }

        if ($division) {
            $division->update($attrs);

            return $division;
        }

        throw new NotFoundHttpException('division tidak di temukan');
    }

    public function delete($id)
    {
        $division = Division::find($id);
        $division->delete();

        return $division;
    }

    public function show($id)
    {
        $division = Division::find($id);

        return $division;
    }

    public function codeIsExists($code, $id = null)
    {
        $division = Division::where('code', $code);
        if ($id) {
            $division->where('id', '!=', $id);
        }

        return $division->exists();
    }
};
