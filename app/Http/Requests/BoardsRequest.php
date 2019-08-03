<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardsRequest extends FormRequest
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

    /**
     * Determine if the request is update
     *
     * @return bool
     */
    protected function isUpdate()
    {
        $needle = ['put', 'patch'];

        return in_array(strtolower($this->input('_method')), $needle)
            or in_array(strtolower($this->header('x-http-method-override')), $needle)
            or in_array(strtolower($this->method()), $needle);
    }

    /**
     * Determine if the request is delete
     *
     * @return bool
     */
    protected function isDelete()
    {
        $needle = ['delete'];

        return in_array(strtolower($this->input('_method')), $needle)
            or in_array(strtolower($this->header('x-http-method-override')), $needle)
            or in_array(strtolower($this->method()), $needle);
    }

}
