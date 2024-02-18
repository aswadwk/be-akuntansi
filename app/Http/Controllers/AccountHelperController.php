<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->route('web.accountHelpers.index');
    }

    public function edit($accountHelperId)
    {
        return inertia('AccountHelper/Edit', [
            'accountHelper' => $this->service->getById($accountHelperId),
        ]);
    }

    public function update($accountHelperId, Request $request)
    {
        $this->service->update($accountHelperId, $request->all());

        return redirect()->route('web.accountHelpers.index');
    }

    public function delete($accountHelperId)
    {
        $this->service->delete($accountHelperId);

        return redirect()->route('web.accountHelpers.index');
    }
}
