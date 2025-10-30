<?php

declare(strict_types=1);

namespace App\Http\Requests\LastFm\Charts;

use Illuminate\Foundation\Http\FormRequest;

class ListWeeklyChartsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->lastfm_user !== null;
    }

    public function rules(): array
    {
        return [];
    }
}
