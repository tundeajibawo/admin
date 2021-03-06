<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;


class RegisterRequest extends FormRequest
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
         Validator::extend('checkspecialcharacter', function ($attribute, $value, $parameters, $validator)
        {  
            $check=true;            
            
            $sp='"%*;<>?^`{|}~\\\'#=&';
            if(preg_match("/[".$sp."]/",$value))
            {
                $check=false;
            }

            
           return $check;
        });

        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'name' => 'required|unique:users,name|checkspecialcharacter',
            'password' => 'required|min:6|confirmed|checkspecialcharacter',
            'password_confirmation' => 'required|min:6',
        ];
    }
    public function messages()
    {
        return[
            
            'password.checkspecialcharacter'=>trans('adduser.specialchar'),
            'name.checkspecialcharacter'=>trans('adduser.specialchar'),
        ];
    }
}
