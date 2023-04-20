<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'max_degree' => $this->max_degree ?? '',
            'min_degree' => $this->min_degree ?? '',
            'details'    => $this->details ?? '',
            'materials'  => $this->materials ? $this->materials->transform(fn ($e) => [
                'id' => $e->id,
                'status' => $e->status,
                'level' => $e->level->name ?? '',
                'material' => $e->material->name ?? '',
                'teacher' => $e->teacher->name ?? '',
                'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            ]) : [],
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
