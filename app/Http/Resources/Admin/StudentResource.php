<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'age'        => $this->age ?? '',
            'email'      => $this->user->email ?? 'ليس لده اسم دخول',
            'details'    => $this->details ?? '',
            'phone'      => $this->phone ?? '',
            'photo'      => $this->photo ? $this->photo->getUrl('thumbnail') : null,
            'level'      => $this->level[0]->level->name ?? '',
            'level_id'   => $this->level[0]->level->id ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
