<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        //Re-use User Request
        $rules = [];
        if($this->getMethod() == 'POST') {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules = [
                'name' => 'required',
            ];
        }

        return $rules;
    }
}
