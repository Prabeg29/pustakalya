<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:App\Models\User,email',
            'username' => 'required|string|unique:App\Models\User,username|max:255',
            'password' => 'required|min:8|max:255|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'confirmPassword' => 'required|same:password'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter your name',
            'name.max' => 'Please enter less than 255 characters',
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email',
            'email.unique' => 'Please enter a different email. This email has already been taken',
            'username.required' => 'Please enter a username',
            'username.unique' => 'Please enter a different username. This username has already been taken',
            'username.max' => 'Please enter less than 255 characters',
            'password.required' => 'Please enter password',
            'password.min' => 'Please enter at least 8 characters',
            'password.max' => 'Please enter less than 255 characters',
            'password.regex' => 'Password must consist of at least 1 uppercase, 1 lowercase, 1 number, and 1 special character',
            'confirmPassword.required' => 'Please enter password again for confirmation',
            'confirmPassword.same' => 'Passwords do not match',
        ];
    }
}
