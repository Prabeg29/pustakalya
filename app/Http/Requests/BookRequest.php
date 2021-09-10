<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'coverImage' => 'string|max:255',
            'authors' => 'required|string|max:255',
            'genres' => 'required|string|max:255',
            'isApproved' => 'boolean'
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
            'title.required' => 'Please enter book title',
            'title.max' => 'Please enter less than 255 characters',
            'description.required' => 'Please enter description',
            'coverImage.max' => 'Please enter less than 255 characters',
            'authors.required' => 'Please enter at least one author',
            'authors.max' => 'Please enter less than 255 characters',
            'genres.required' => 'Please enter at least one genre',
            'genres.max' => 'Please enter less than 255 characters',
            'isApproved.boolean' => 'Value can be either true or false',
        ];
    }
}
