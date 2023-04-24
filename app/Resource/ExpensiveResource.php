<?php

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;

class ExpensiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'price'       => number_format($this->price, 2, '.', '.'),
            'created_at'  => Carbon::createFromDate($this->created_at)->format('d/m/Y H:i:s')
        ];
    }
}
