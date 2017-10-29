<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|email|unique:clients,email',
            'company' => 'required|string',
            'phone' => 'required|string',
            'comment' => 'required|string',
            'labels' => 'array',
            'labels.*' => 'integer|exists:labels,id',
            'new-labels' => 'array',
            'new-labels.*.name' => 'required|string',
            'new-labels.*.color' => 'required|regex:/(^#[a-zA-z0-9]{3,6}$)/u'
        ];
    }
}
