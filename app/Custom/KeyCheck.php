<?php


namespace App\Custom;


use App\Codex;
use App\KeyAttempt;
use Illuminate\Support\Facades\Auth;

class KeyCheck
{
    private $software_key;
    private $activation_code;
    private $current_date;

    private $expire;
    private $max_atm;
    private $salt;
    private $salt_re;

    public function __construct()
    {
        $this->get_business = Auth::user()->business_id;
        $this->software_key = Auth::user()->business['software_key'];
        $this->current_date = date("Y-m-d");
        $this->expire = 22022;
        $this->max_atm = 10; //Maximum Attempt
        $this->salt = 'my*name%is!nazmu1';
        $this->salt_re = 'nadu%!o256b*te';
    }

    public function code($activation_code){//Activation Code
        $this->activation_code = strtolower($activation_code);
    }

    private function save_attempt(){
        $att = new KeyAttempt();
        $att->code = $this->activation_code;
        $att->business_id = $this->get_business;
        $att->save();
    }

    private function delete_attempt(){
        KeyAttempt::where('business_id', $this->get_business)->delete();
    }

    private function activator(){
        $hex_num = hex2bin($this->activation_code);
        $key = openssl_decrypt($hex_num, "AES-128-ECB", $this->salt);
        if($key){
            $splite = explode(" - ",$key);

            if($splite[1] == $this->software_key){
                $timestamp = $splite[0];
                if(is_timestamp($timestamp)){
                    $curentlap = strtotime($this->current_date);

                    if($timestamp >= $curentlap) {
                        $check = Codex::where('business_id', $this->get_business)->first();//Codex Table
                        if($check == null){

                            $table = new Codex();//Codex Table
                            $table->current_code = bin2hex(openssl_encrypt(($timestamp - $this->expire), "AES-128-ECB", $this->salt_re));
                            $table->last_code = $this->activation_code;
                            $table->business_id = $this->get_business;
                            $table->save();

                            $this->delete_attempt();
                            return true;

                        }else{
                            if ($check->last_code != $this->activation_code) {
                                //Codex Table
                                Codex::where('business_id', $this->get_business)->update([
                                    'current_code' => bin2hex(openssl_encrypt(($timestamp - $this->expire), "AES-128-ECB", $this->salt_re)),
                                    'last_code' => $this->activation_code
                                ]);

                                $this->delete_attempt();
                                return true;

                            }else{
                                $this->save_attempt();
                                throw new \Exception('Invalid Activation Code');
                            }
                        }
                    }else{
                        $this->save_attempt();
                        throw new \Exception('Invalid Activation Code');
                    }

                }else{
                    $this->save_attempt();
                    throw new \Exception('Invalid Activation Code');
                }
            }else{
                $this->save_attempt();
                throw new \Exception('Invalid Activation Code');
            }

        }else{
            $this->save_attempt();
            throw new \Exception('Invalid Activation Code');
        }
    }

    private function check_attempt(){
        $attempt_check = KeyAttempt::where('business_id', $this->get_business)->count();
        if($attempt_check < $this->max_atm) {

            return true;

        }else{
            throw new \Exception('Violence Attempt!! Contact With Software Provider.');
        }

    }

    private function ck_codex(){
        $check = Codex::where('business_id', $this->get_business)->first();
        if($check != null){
            $enkey = openssl_decrypt(hex2bin($check->current_code), "AES-128-ECB", $this->salt_re);
            $key_timestamp = ($enkey + $this->expire);

            if ($key_timestamp > strtotime($this->current_date)) {
                return true;
            }else{
                throw new \Exception('Activation Code Not Found.');
            }
        }else{
            throw new \Exception('Activation Code Not Found.');
        }
    }

    public function dc(){ //Code Validating
        try {
            return $this->ck_codex();
        } catch (\Exception $e) {
            return  false;
        }
    }

    public function day_remain(){
        $check = Codex::where('business_id', $this->get_business)->first();
        if($check != null){
            $enkey = openssl_decrypt(hex2bin($check->current_code), "AES-128-ECB", $this->salt_re);
            $key_timestamp = ($enkey + $this->expire);
            $exp = date('d/m/Y', $key_timestamp);
            return remain_day($exp);
        }else{
            return 0;
        }
    }

    public function activate(){
        try {
            $this->check_attempt();
            return $this->activator();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }


}