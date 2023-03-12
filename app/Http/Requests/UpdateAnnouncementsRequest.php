<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementsRequest extends FormRequest
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
            'name'        => "required|string|max:50",
            'description'        => "required|integer|max:50",
            'num_announcement'        => "required|integer|max:50",
            'y_announcement'        => "required|integer|max:50",
            'status'        => "required|integer|max:50",
            'institutions_id' => "required|string|max:45|exist:institutions,id",
        ];
    }
}
