<?php


namespace App\Custom;


use Illuminate\Support\Str;

class DbDate
{
    private $date_set;
    private $f_date;
    private $t_date;
    private $db_date;


    public function __construct($date)
    {
        $this->date_set = $date;
    }

    private function validate(){
        $contains = Str::contains($this->date_set, ' - ');//Check Date Range
        if($contains){
            $split = explode(" - ",$this->date_set);
            $fromDate = str_replace("/", "-",  $split[0]);
            $toDate = str_replace("/", "-",  $split[1]);
            if(strtotime($fromDate) && strtotime($toDate)){
                $this->f_date = $fromDate;
                $this->t_date = $toDate;
            }else{
                throw new \Exception('Invalid Date');
            }
        }else{
            if(strtotime(str_replace("/", "-",  $this->date_set))){
                $this->db_date = str_replace("/", "-",  $this->date_set);
            }else{
                throw new \Exception('Invalid Date');
            }
        }
    }

    public function form(){
        try {
            $this->validate();

            return date('Y-m-d', strtotime($this->f_date));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function to(){
        try {
            $this->validate();

            return date('Y-m-d', strtotime($this->t_date));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function db(){
        try {
            $this->validate();

            return date('Y-m-d', strtotime($this->db_date));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function from_tz()
    {
        try {
            $this->validate();

            return date('Y-m-d H:i:s', strtotime($this->f_date));

        } catch (\Exception $e) {
            return $e;
        }
    }


    public function to_tz()
    {
        try {
            $this->validate();

            return date('Y-m-d H:i:s', strtotime($this->t_date.' 23:59:59'));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ftr(){
        return array($this->from_tz(), $this->to_tz());
    }

    public function db_st(){
        try {
            $this->validate();

            return date('Y-m-d H:i:s', strtotime($this->db_date));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function db_end(){
        try {
            $this->validate();

            return date('Y-m-d H:i:s', strtotime($this->db_date.' 23:59:59'));

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ser(){
        return array($this->db_st(), $this->db_end());
    }

    public function gen_list(){
        $date_from = strtotime($this->form());
        $date_to  = strtotime($this->to());

        $list = array();
        for ($i=$date_from; $i<=$date_to; $i+=86400) {
            array_push($list, date("Y-m-d", $i));
        }
        return $list;
    }

}