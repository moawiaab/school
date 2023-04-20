<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title ?? '',
            'details'    => $this->details ?? '',
            'url'        => $this->url ?? '',
            'material'   => $this->material ? $this->material->material->name : '',
            'level'      => $this->material ? $this->material->level->name : '',
            'teacher'    => $this->material ? $this->material->teacher->name : '',
            'user'       => $this->user->name ?? '',
            'audio'      => $this->audios ? $this->audios->getUrl() : '',
            'answers'       => $this->asks->transform(fn ($i) => [
                'id'      => $i->id,
                'ask'     => $i->ask,
                'details' => $i->details,
                'answers' => $i->answers->transform(fn ($e) => ['answer' => $e->answer, 'status' => $e->status])
            ]),
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
