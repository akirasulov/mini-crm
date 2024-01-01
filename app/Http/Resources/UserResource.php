<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullname' => $this->fullname,
            'name' => $this->name,
            'surname' => $this->surname,
            'login' => $this->login,
            'email' => $this->email,
            'profile_photo_path' => $this->hasMedia('images') ? $this->getMedia('images')->first()->getFullUrl() : false,
            'deleted_at' => $this->deleted_at,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ];
    }
}
