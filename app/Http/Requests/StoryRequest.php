<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if(request()->isMethod('PUT')){
            return [
                'name' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'category_id' => ['required', 'integer'],
                'user_id' => ['required', 'integer'],
                'image' => ['nullable','image','max:3048'],
            ];
        }
        return [
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'image' => ['required','image','max:3048'],
        ];
    }
}
