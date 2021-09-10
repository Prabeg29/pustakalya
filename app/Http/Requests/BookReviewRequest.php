<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookReviewRequest extends FormRequest
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
            'review' => 'required|string',
            'rating' => 'required|numeric|between:0,5'
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
            'review.required' => 'Please enter review',
            'rating.required' => 'Please enter rating',
            'rating.numeric' => 'Please enter numeric value',
            'rating.between' => 'Rating is between 0 and 5',
        ];

    }
}
