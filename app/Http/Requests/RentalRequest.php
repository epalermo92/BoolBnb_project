<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalRequest extends FormRequest
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

        'title' => 'required',
        'description' => 'required',

        'rooms' => 'required|',
        'bathrooms' => 'required',
        'beds' => 'required',
        'square_meters' => 'required',
        'address' => 'required',
        'lat' => 'required',
        'lon' => 'required',
        'image' => 'required|image'
        // 'services' => 'required'
      ];

    }
}
