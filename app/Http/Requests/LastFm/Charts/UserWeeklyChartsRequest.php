<?php

declare(strict_types=1);

namespace App\Http\Requests\LastFm\Charts;

use Illuminate\Foundation\Http\FormRequest;

class UserWeeklyChartsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'user' => ['required', 'exists:users,id'],
        ];
    }
}
