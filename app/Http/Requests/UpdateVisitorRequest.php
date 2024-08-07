<?php

namespace App\Http\Requests;

use App\Models\Visitor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitorRequest extends FormRequest
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
        $rules = Visitor::$rules;
        $rules['no_of_person'] = 'max:4';

        return $rules;
    }
}
