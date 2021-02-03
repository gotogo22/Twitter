<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

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
     * @return array
     */
    public function rules(User $user)
    {
        return [
            // 'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'screen_name'   => ['required', 'string', 'max:50'],
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            // 'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
            'email'         => ['required', 'string', 'email', 'max:255']
        ];
    }
}
