<?php

namespace App\Http\Requests;

class CreateUserRequest extends Request
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
        $rule = config('common.user.rule');

        return [
            'name' => "max:{$rule['name_max']}",
            'email' => "required|email|max:{$rule['email_max']}|unique:users",
            'password' => "required|min:{$rule['password_min']}",
            'image' => "image|max:{$rule['image_size']}",
        ];
    }
}
