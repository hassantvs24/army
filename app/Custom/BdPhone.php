<?php


namespace App\Custom;


class BdPhone
{
    private $phoneNumber;
    private $pattern = '/(^(\+88|0088)?(01){1}[3456789]{1}(\d){8})$/';

    function __construct($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    private  function rg_expression(){

        if(preg_match($this->pattern, $this->phoneNumber)){
            return true;
        }else{
            throw new \Exception('Invalid Number.');
        }
    }


    public function check(){
        try {
            return $this->rg_expression();
        } catch (\Exception $e) {
            return false;
        }
    }
}