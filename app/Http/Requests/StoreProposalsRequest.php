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
            'title' => "required|string|max:45",
            'line_research' => "required|string|max:45",
            'abstract' => "required|string|max:45",
            'problem_statement' => "required|string|max:45",
            'justification' => "required|string|max:45",
            'background' => "required|string|max:45",
            'technical_manager_experience' => "required|string|max:45",
            'capcities' => "required|string|max:45",
            'general_objective' => "required|string|max:45",
            'specific_objective' => "required|string|max:45",
            'expected_results' => "required|string|max:45",
            'expected_results_review' => "required|string|max:45",
            'differentiators' => "required|string|max:45",
            'benefits' => "required|string|max:45",
            'products_generated' => "required|string|max:45",
            'ownership_proposal' => "required|string|max:45",
            'announcement_id' => "required|string|max:45|exist:announcements,id",
            'area_knowledge_id' => "required|string|max:45|exist:areas_knowledge,id",
            'user_id' => "required|string|max:45|exist:users,id",
        ];
    }
}
