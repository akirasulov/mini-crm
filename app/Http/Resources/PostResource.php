<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid ' => $this->uuid,
            'fullname' => $this->fullname,
            'operator_id' => $this->operator_id,
            'title' => $this->title,
            'body' => $this->body,
            'msisdn' => $this->msisdn,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y h:i:s'),
            'deleted_at' => $this->deleted_at,
            'operator' => $this->operator()->get()->transform(fn($user) => [
                'id' => $user->id,
                'fullname' => $user->fullname,
            ])[0],
            'comments' => CommentResource::collection($this->comments->load('user')),
        ];
    }
}
