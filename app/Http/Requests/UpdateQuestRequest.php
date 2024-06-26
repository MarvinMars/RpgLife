<?php

namespace App\Http\Requests;

use App\Models\Quest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestRequest extends FormRequest
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
            'slug' => ['required', Rule::unique(Quest::class)->ignore($this->route('quest')->id ?? 0), 'string'],
            'xp' => ['nullable', 'numeric'],
            'characteristics' => ['nullable', 'array'],
            'characteristics.*' => ['exists:characteristics,id'],
        ];
    }
}
