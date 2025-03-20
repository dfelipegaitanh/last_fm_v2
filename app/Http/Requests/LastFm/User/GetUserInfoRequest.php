<?php

declare(strict_types=1);

namespace App\Http\Requests\LastFm\User;

use Illuminate\Foundation\Http\FormRequest;

class GetUserInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->lastFmUser !== null;
    }

    public function rules(): array
    {
        return [];
    }
}
