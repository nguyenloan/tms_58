<?php

namespace App\Http\Requests;

class UpdateUserRequest extends Request
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
        $parts = explode("/", UpdateUserRequest::path());
        $userId = end($parts);
        $rule = config('common.user.rule');

        return [
            'name' => "max:{$rule['name_max']}",
            'email' => "required|email|max:{$rule['email_max']}|unique:users,email,{$userId},id",
            'image' => "mimes:jpg,jpeg,png,gif|max:{$rule['image_size']}",
        ];
    }
}
