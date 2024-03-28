<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Uppercase implements ValidationRule
{
    private $attribute = null;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value){
        $this->attribute = $attribute;
        if ($value===mb_strtoupper($value, 'UTF-8')){
            return true;
        }
    }

    public function message(){
        //return 'Truong :attribute khong hop le';

        $customMessage = 'validation.custom.' .($this->attribute).'.uppercase';

        if (trans($customMessage)!=$customMessage){
            return trans($customMessage);
        }

        return trans('validation.uppercase');
    }

}
