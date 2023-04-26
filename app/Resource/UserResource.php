<?php

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => Carbon::createFromDate($this->created_at)->format('d/m/Y H:i:s'),
            'update_at'  => Carbon::createFromDate($this->update_at)->format('d/m/Y H:i:s')
        ];
    }
}
