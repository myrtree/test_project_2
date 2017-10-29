<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => 'string',
            'email' => 'email|unique:clients,email',
            'company' => 'string',
            'phone' => 'string',
            'comment' => 'string',
            'labels' => 'array',
            'labels.*' => 'integer|exists:labels,id',
            'new-labels' => 'array',
            'new-labels.*.name' => 'required|string',
            'new-labels.*.color' => 'required|regex:/(^#[a-zA-z0-9]{3,6}$)/u'
        ];
    }
}
