<?php

namespace App\Http\Requests\Officer\Report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateReport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('officer.report.edit', $this->report);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'report_time' => ['sometimes', 'date'],
            'title' => ['sometimes', 'string'],
            'content' => ['sometimes', 'string'],
            'picture_url' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
            'citizen_id' => ['sometimes', 'integer'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }

    public function getCitizenId() {
        if ($this->has('citizen')) {
            return $this->get('citizen')['id'];
        }
        return null;
    }
}
