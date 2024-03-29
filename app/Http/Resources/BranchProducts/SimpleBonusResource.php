<?php

namespace App\Http\Resources\BranchProducts;

use App\Models\Bonus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleBonusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Bonus|JsonResource $this */
        return [
            'id'                => $this->when($this->id, $this->id),
            'bonus_quantity'    => $this->when($this->bonus_quantity, $this->bonus_quantity),
            'bonus_stock_id'    => $this->when($this->bonus_stock_id, $this->bonus_stock_id),
            'value'             => $this->when($this->value, $this->value),
            'type'              => $this->when($this->type, $this->type),
            'status'            => (boolean)$this->status,
            'expired_at'        => $this->when($this->expired_at, $this->expired_at->format('Y-m-d')),
        ];
    }
}
