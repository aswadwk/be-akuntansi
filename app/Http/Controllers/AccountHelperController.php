<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountHelper\CreateRequest;
use App\Http\Requests\AccountHelper\UpdateRequest;
use App\Services\AccountHelperService;
use Illuminate\Http\Request;

class AccountHelperController extends Controller
{
    private $service;

    public function __construct(
        AccountHelperService $service
    ) {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return inertia('AccountHelper/Index', [
            'accountHelpers' => $this->service->getAll($request->all()),
        ]);
    }

    public function create()
    {
        return inertia('AccountHelper/Create');
    }

    public function store(CreateRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('web.accountHelpers.index');
    }

    public function edit($accountHelperId)
    {
        return inertia('AccountHelper/Edit', [
            'accountHelper' => $this->service->getById($accountHelperId),
        ]);
    }

    public function update($accountHelperId, UpdateRequest $request)
    {
        $this->service->update($accountHelperId, $request->validated());

        return redirect()->route('web.accountHelpers.index');
    }

    public function delete($accountHelperId)
    {
        $this->service->delete($accountHelperId);

        return redirect()->route('web.accountHelpers.index');
    }
}
