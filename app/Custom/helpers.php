<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

if (! function_exists('money_c')) {
    function money_c($amount){
        return number_format($amount, 2);
    }
}

if (! function_exists('pub_date')) {
    function pub_date($date){
        if($date == ''){
            return '';
        }else{
            return date("d/m/Y", strtotime(str_replace("/", "-",  $date)));
        }
    }
}

if (! function_exists('db_date')) {
    function db_date($date, $istime=true){
        if($date == '' || $date == null){
            return null;
        }else{
            if($istime){
                $times = date('H:i:s');
                try {
                    $idt = date("Y-m-d", strtotime(str_replace("/", "-",  $date)));
                    $dt = new DateTime($idt . ' ' . $times);
                } catch (Exception $e) {
                    throw new \Exception($e);
                }
                return $dt->format('Y-m-d H:i:s');
            }else{
                $idt = date("Y-m-d", strtotime(str_replace("/", "-",  $date)));
                return $idt;
            }

        }
    }
}

if (! function_exists('db_se_date')) {
    function db_se_date($date){
        $db_date = db_date($date, false);

        $start = Carbon::createFromFormat('Y-m-d', $db_date)->startOfDay()->toDateTimeString();
        $end = Carbon::createFromFormat('Y-m-d', $db_date)->endOfDay()->toDateTimeString();

        return array($start, $end);
    }
}


if (!function_exists('db_result')) {
    function db_result($data)
    {
        return ['message' => 'Data Successfully Find', 'data' => $data];
    }
}

if (!function_exists('checkNull')) {
    function checkNull($val)
    {
        return ($val === 'null' ? '' : $val);
    }
}

if (!function_exists('validate_error')) {
    function validate_error($error)
    {
        return ['message' => $error];
    }
}

if (!function_exists('del_file')) {

    function del_file($path, $disk)
    {

        $exists = Storage::disk($disk)->exists($path);
        if ($exists) {
            Storage::disk($disk)->delete($path);
        }

        return true;
    }
}


if (!function_exists('validate_error')) {
    function validate_error($error)
    {
        return ['message' => $error];
    }
}

if (!function_exists('null_filter')) {
    function null_filter($value)
    {
        if($value == 'null'){
            return '';
        }

        return $value;
    }
}

if (!function_exists('ck_status')) {
    function ck_status($status, $check=null)
    {
        if($status != $check){
            return 'Inactive';
        }

        return 'Active';
    }
}


if (!function_exists('is_timestamp')) {
    function is_timestamp($timestamp)
    {
        $check = (is_int($timestamp) OR is_float($timestamp))
            ? $timestamp
            : (string) (int) $timestamp;
        return  ($check === $timestamp)
            AND ( (int) $timestamp <=  PHP_INT_MAX)
            AND ( (int) $timestamp >= ~PHP_INT_MAX);
    }
}


if (!function_exists('remain_day')) {
    function remain_day($date){
        $date1 = date("Y-m-d");
        $date2 = date("Y-m-d", strtotime(str_replace("/", "-",  $date)));
        $earlier = new DateTime($date2);
        $later = new DateTime($date1);
        $diff = $later->diff($earlier)->format("%r%a");
        return (int)$diff;
    }
}




if (!function_exists('in_word')) {
    function in_word($num = false)
    {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words).' only.';
    }
}