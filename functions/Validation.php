<?php

namespace Functions;

class Validation{
    public $rules;
    public $errors;
    public $inputs;
    //public $errors;

    public function validate(){
        foreach ($this->inputs as $name => $value) {
            $rules = $this->rules[$name];
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                $rule = explode(':', $rule);
                $function = $rule[0];
                $param = $rule[1] ?? '';
                call_user_func_array([$this, $function], [$name, $value, $param]);
            }
        }
    }

    public function required($name, $value){
        if(empty($value)){
            $this->errors[] = $name . ' is required';
        }
    }

    public function email($name, $value){
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errors[] = 'Invalid Email';
        }
    }

    public function numeric($name, $value){
        if(!is_numeric($value)){
            $this->errors[] = $name . ' must be a valid number';
        }
    }

    public function min($name, $value, $min){
        if($value < $min){
            $this->errors[] = $name . ' can\'t be less than ' . $min . ' characters';
        }
    }

    public function in_array($name, $value, $array){
        $array = explode(',', $array);
        if(!in_array($value, $array)){
            $this->errors[] = 'Please select a valid ' . $name;
        }
    }
}