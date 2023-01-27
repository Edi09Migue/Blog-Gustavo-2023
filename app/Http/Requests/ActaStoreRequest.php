<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActaStoreRequest extends FormRequest
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
            'codigo'=>"unique:actas",
            'junta_id'=>'required',
            'votos_blancos'=>'required',
            'votos_nulos'=>'required',
            'total_votantes'=>'required',
            'estado'=>'required',
            'ingresada_por'=>'required',
            // 'visualizado'=>'required',
        ];
    }
}
