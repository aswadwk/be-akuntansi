<?php

namespace App\Services\Impl;

use App\Exceptions\NotFoundError;
use App\Models\Division;
use App\Services\DivisionServiceInterface;
use Illuminate\Validation\ValidationException;

class DivisionService implements DivisionServiceInterface
{
    public function search($id = null, $attrs)
    {
        $code = $attrs['code'] ?? null;
        $name = $attrs['name'] ?? null;

        if ($id) {
            return Division::find($id);
        }

        if(isset($attrs['all'])){

            return Division::get();
        }

        if ($code) {
            return Division::where('code', $code)->first();
        }

        $division = Division::query();
        if ($name) {
            $division->where('name', 'like', '%'.$name.'%');
        }

        return $division->get();
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

        throw new NotFoundError('division tidak di temukan');
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
}

;
