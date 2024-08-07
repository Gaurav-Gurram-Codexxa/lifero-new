<?php

namespace App\Http\Requests;

use App\Models\TeleCaller;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeleCallerRequest extends FormRequest
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
        $rules = TeleCaller::$rules;
        $rules['email'] = 'required|email:filter|unique:users,email,'.$this->route('tele_caller')->user->id;

        return $rules;
    }
}
