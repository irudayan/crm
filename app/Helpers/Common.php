<?php

namespace App\Helpers;

use Auth;
use Carbon\Carbon;
use Config;
use DateTime;
use DateTimeZone;
use DB;

class Common
{

    /**
     * Replace the null value with empty
     *
     * @return
     */

    public static function replaceNull($value)
    {
        return ($value == null) ? '' : $value;
    }

    /**
     * Apply colors based on status
     *
     * @return
     */

    public static function applyColors($statusId)
    {
        if ($statusId == 'active') {
            return ' bg-gradient-success';
        } elseif ($statusId == 'inactive') {
            return ' bg-gradient-danger';
        } else {
            return '';
        }
    }

    public static function applyColorsApproved($statusId)
    {
        if ($statusId == '1') {
            return ' bg-gradient-success';
        } elseif ($statusId == '0') {
            return ' bg-gradient-danger';
        } else {
            return '';
        }
    }

    /**
     * Split the date as dd/mm/yyyy to yyyy-mm-dd -- form to mysql db
     *
     * @return
     */

    public static function formatDateMysqlExcel($date)
    {

        if ($date) {
            $date = explode('/', $date);
            $month = $date[0];
            $day = $date[1];
            $year = $date[2];
            return $year . "/" . $month . "/" . $day;
        } else {
            return '';
        }
    }

    public static function formatDateMysql($date)
    {
        if ($date) {
            $date = explode('/', $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2];
            return $year . "/" . $month . "/" . $day;
        } else {
            return '';
        }
    }

    public static function formatMysql($date)
    {
        if ($date) {
            $date = explode('-', $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2];
            return $year . "-" . $month . "-" . $day;
        } else {
            return '';
        }
    }

    /**
     * To format date as dd-mm-yyyy
     */
    public static function formatDate($date)
    {
        if ($date) {
            $date = explode('-', $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2];
            return $day . "-" . $month . "-" . $year;
        } else {
            return '';
        }
    }

    /**
     * Split the date as mm/dd/yyyy from yyyy-mm-dd -- form to mysql bmysql to form
     *
     * @return
     */

    public static function formatDateReverseMysql($date)
    {
        if ($date) {
            $date = explode('-', $date);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            return $month . "-" . $day . "-" . $year;
        } else {
            return '';
        }
    }
    public static function formatDate2($datetime)
    {
        $date = new DateTime($datetime);
        $indian_timezone = new DateTimeZone('Asia/Kolkata');
        $date->setTimezone($indian_timezone);
        $formatted_date = $date->format('d-m-Y h:i A');
        return $formatted_date;
    }
    
     public static function convert12HoursDateTimew($datetime)
    {
        if ($datetime) {
            //  $convert12hours = new DateTime($time);
            // return $convert12hours->format('h:i:s');
            return date('d-m-Y h:i:s A', strtotime($datetime));
        }
    }

    public static function formatDate1($datetime)
    {
        if ($datetime) {

            $dt = explode(" ", $datetime);
            $parse_date = explode('-', $dt[0]);
            $format_date = $parse_date[2] . '-' . $parse_date[1] . '-' . $parse_date[0];
            return $format_date;
        } else {
            return '';
        }
    }

    /**
     * Display limited texts
     *
     * @return
     */

    public static function displayLimitText($string, $limit)
    {
        return strlen($string) > $limit ? substr($string, 0, $limit) . "..." : $string;
    }

    public static function strNormalCase($str)
    {
        return ucwords(strtolower($str));
    }

    /**
     * Convert textarea text with linebreak
     *
     * @return
     */

    public static function displayTextNl2br($string)
    {
        return nl2br(e($string));
    }

    /**
     * Format UTC to PST time
     *
     * @return
     */

    public static function convertDateTimeUS($datetime)
    {
        if (!empty($datetime)) {
            //return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, 'UTC')->setTimezone('America/Los_Angeles');
            return Carbon::createFromFormat('Y-m-d', $datetime)->format(Config::get('app.datetime_format1'));
        } else {
            return '';
        }
    }

    /**
     * Format Date to US
     *
     * @return
     */

    public static function convertDateUS($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format(Config::get('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * To create secret URL and check
     */
    public static function makeSecureId($Id)
    {
        if (Auth::check()) {
            return hash_hmac(
                'sha1',
                $Id . Auth::user()->id,
                config("global.DSID")
            ) . '-' . $Id;
        }
    }

    /**
     * To check the secret url on view page
     */
    public static function verifySecureId($varIdCheck)
    {
        //echo $varIdCheck; exit;
        if (!strstr($varIdCheck, '-')) {
            die('Error: Invalid Request');
        }

        list($hash, $originalId) = explode('-', $varIdCheck);

        if (Auth::check()) {
            if (
                hash_hmac(
                    'sha1',
                    $originalId . Auth::user()->id,
                    config("global.DSID")
                ) === $hash
            ) {
                return $originalId;
            } else {
                echo '<br>The requested page does not exist. &nbsp; <a href="javascript:void(0);" onclick="window.history.back();">Go Back</a>';
                die();
            }
        }
    }

    /**
     * To show status based on 0 or 1
     */
    public static function showStatus($status)
    {
        if ($status == 1) {
            return config('panel.status.1');
        } elseif ($status == 0) {
            return config('panel.status.0');
        } else {
            return '';
        }
    }

    /**
     * To show 24 hours time format to 12 hours format
     * 17.00 to 5 PM
     */
    public static function convert12HoursTime($time)
    {
        if ($time) {
            //  $convert12hours = new DateTime($time);
            // return $convert12hours->format('h:i:s');
            return date('h:i A', strtotime($time));
        }
    }

    /**
     * To show 24 hours date time format to 12 hours format
     * 17.00 to 5 PM
     */
    public static function convert12HoursDateTime($datetime)
    {
        if ($datetime) {
            //  $convert12hours = new DateTime($time);
            // return $convert12hours->format('h:i:s');
            return date('d-m-Y h:i A', strtotime($datetime));
        }
    }

    /**
     * To show diff style
     */
    public static function showColor($status)
    {
        if ($status == 0 || $status == 'inactive') {
            return 'badge badge-sm  bg-gradient-danger';
        } elseif ($status == 1 || $status == 'active') {
            return 'badge badge-sm  bg-gradient-success';
        } else {
            return '';
        }
    }

    public static function showStatusColor($status)
    {
        if ($status == 'Completed' || $status == 'C' || $status == 'replied') {
            return 'badge badge-success';
        } else {
            return 'badge badge-danger';
        }
    }

    public static function numberFormat($amount)
    {
        return number_format((float) $totalAmount, 2, '.', '');
    }

    public static function getCurrencyInWords(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = null;
            }
        }
        $Rupees = implode('', array_reverse($str));
        //$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        //return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        return ucwords($Rupees);
    }

    public static function separateComma1($string_number)
    {
        // NOTE: You don't really have to use floatval() here, it's just to prove that it's a legitimate float value.
        $number = floatval(str_replace(',', '.', str_replace('.', '', $string_number)));

        // At this point, $number is a "natural" float.
        return $number;
    }

    /**
     * To have indian money format currecny-format
     */
    public static function indMoneyFormat($number)
    {
        $decimal = (string) ($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $delimiter .= ',';
            }
            $delimiter .= $money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if ($decimal != '0') {
            $result = $result . $decimal;
        }

        return $result;
    }
}
