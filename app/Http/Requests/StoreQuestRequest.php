<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'slug' => ['required', 'unique:quests,slug', 'string'],
            'xp' => ['nullable', 'numeric'],
            'parent_id' => ['nullable', 'exists:quests,id'],
            'characteristics' => ['nullable', 'array'],
            'characteristics.*' => ['exists:characteristics,id'],
        ];
    }
}
