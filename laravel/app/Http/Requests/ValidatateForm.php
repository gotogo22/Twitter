<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Rule;

class ValidatateForm extends FormRequest
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
            // 'tweet_id' =>['required', 'integer'],
            'text'     => ['required', 'string', 'max:140'],
            // 'screen_name'   => ['required', 'string', 'max:50'],
            // 'name'          => ['required', 'string', 'max:255'],
            // 'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

    }
}
