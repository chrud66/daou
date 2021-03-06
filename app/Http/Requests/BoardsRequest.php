<?php

namespace App\Http\Requests;

class BoardsRequest extends Request
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
        } elseif ($this->isUpdate()) {
            $rules = [
                'subject' => 'required|string|max:200',
                'content' => 'required|string',
            ];
        } else {
            $rules = [
                'subject' => 'required|string|max:200',
                'content' => 'required|string',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'subject.required'  => '제목을 입력하세요.',
            'subject.max'       => '제목이 너무 깁니다.',
            'content.required'  => '내용을 입력하세요.',
        ];
    }
}
