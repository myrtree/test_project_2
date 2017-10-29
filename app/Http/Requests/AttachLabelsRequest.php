<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachLabelsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'labels' => 'required_without:new-labels|array',
            'labels.*' => 'string|exists:labels,id',
            'new-labels' => 'required_without:labels|array',
            'new-labels.*.name' => 'required|string|unique:clients,email',
            'new-labels.*.color' => 'required|regex:/(^#[a-zA-z0-9]{3,6}$)/u',
        ];
    }
}
