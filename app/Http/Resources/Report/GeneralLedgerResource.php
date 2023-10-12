<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralLedgerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_id' => $this->account_id ?? null,
            'name' => $this->account->name ?? null,
            'code' => $this->account->code ?? null,
            'date' => $this->date ?? null,
            'debit' => $this->debit ?? null,
            'credit' => $this->credit ?? null,
            'balance' => $this->balance ?? null,
            'amount' => $this->amount ?? null,
            'type' => $this->type ?? null,
            'description' => $this->description ?? null,
        ];
    }
}
