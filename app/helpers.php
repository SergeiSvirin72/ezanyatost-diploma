<?php

if (! function_exists('findValue')) {
    function generateDates($start, $end, $weekDays) {
        $interval = DateInterval::createFromDateString('1 day');
        $period   = new DatePeriod($start, $interval, $end);
        $dates = [];
        foreach ($period as $date) {
            if (in_array($date->format("N"), $weekDays)) {
                $dates[] = $date;
            }
        }
        return $dates;
    }

    function findValue($params, $keys, $data) {
        $length = count($params);
        $results = [];
        foreach($data as $d) {
            $flag = true;
            for($i = 0; $i < $length; $i++) {
                $key = $keys[$i];
                if($d->$key != $params[$i]) $flag = false;
            }
            if($flag) $results[] = $d;
        }
        if(!empty($results)) return $results;
    }

    function formatName($name) {
        $array = explode(' ', $name);
        return $array[0].' '
            .mb_substr($array[1], 0, 1, 'UTF-8').'.'
            .mb_substr($array[2], 0, 1, 'UTF-8').'.';
    }
}
