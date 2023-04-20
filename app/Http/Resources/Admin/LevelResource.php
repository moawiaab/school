<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'details'    => $this->details ?? '',
            'teachers'   => $this->teachers ?? [],
            'teacher'    => $this->teachers->count() ?? 0,
            'materials'  => $this->materials->transform(fn ($e) => [
                'name' => $e->name,
                'details' => $e->name,
                'max_degree' => $e->max_degree,
                'min_degree' => $e->min_degree,
                'teacher' => $e->teachers ?? []
            ]) ?? [],
            'material'   => $this->materials->count() ?? 0,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
