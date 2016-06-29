<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateCourseRequest extends Request
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
        $rule = config('common.course.rule');

        return [
            'name' => "required|max:{$rule['name_max']}",
            'description' => 'required',
        ];
    }
}
