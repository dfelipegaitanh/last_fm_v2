<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'lastfm_user' => $this->lastfm_user,
            'token' => $this->resource
                ->createToken(
                    'Token: '.$this->email,
                    ['*'],
                    now()->addDay()
                )
                ->plainTextToken,
        ];
    }
}
