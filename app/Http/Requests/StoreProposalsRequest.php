<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposalsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => "required|string|max:255",
            'announcement_id' => "required|string|max:255",
            'area_knowledge_id' => "required|string|max:255",
            'user_id' => "required|string|max:255",
            'state_id' => "required|string|max:255",
            'myFiles' => "exclude",
            'fields' => "exclude",
        ];
    }
}
