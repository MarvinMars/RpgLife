<?php

namespace App\Http\Requests;

use App\Models\Characteristic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCharacteristicRequest extends FormRequest
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
		    'slug' => ['required', Rule::unique(Characteristic::class)->ignore($this->route('characteristic')->id ?? 0), 'string']
	    ];
    }
}
