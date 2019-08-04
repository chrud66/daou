<?php

namespace App\Http\Requests;

class CommentsRequest extends Request
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
        if ($this->isDelete()) {
            $rules = [];
        } else {
            $rules = ['content' => 'required|string',];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'content.required'  => '내용을 입력하세요.',
        ];
    }
}
