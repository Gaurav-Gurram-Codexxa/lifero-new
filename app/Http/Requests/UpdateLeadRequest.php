<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = Lead::$rules;
        $rules['email'] = 'required|email:filter|unique:leads,email,'.$this->route('lead')->id;
        $rules['contact'] = 'required|unique:leads,contact,'.$this->route('lead')->id;

        return $rules;
    }
}
