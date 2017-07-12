<?php

class LocalTime {


	public function __construct() {
        
    }
    
    public static function toLocal($client, $time="now") {
        if (is_numeric($time)) {
            $timestamp = $time;
        }
        elseif(is_string($time)) {
            $timestamp = strtotime($time);
        }  
        else {
            $timestamp = time();
        } 
        
        // $timestamp = (is_numeric($time)) ? $time : time();
        $timezone = self::localTimezone($client);
        
        // create a date using this 
        $now = new \DateTime(date("m/d/Y g:i:s A", $timestamp), new \DateTimeZone($timezone));
        
        return $timestamp + (-1 * $now->getOffset());
        
        
    }
    
    
    public static function toGM($client, $time=null) {
        
        if (is_numeric($time)) {
            $timestamp = $time;
        }
        elseif(is_string($time)) {
            $timestamp = strtotime($time);
        }  
        else {
            $timestamp = time();
        } 
        
        // $timestamp = (is_numeric($time)) ? $time : time();
        $timezone = self::localTimezone($client);
        
        // create a date using this 
        $now = new \DateTime(date("m/d/Y g:i:s A", $timestamp), new \DateTimeZone($timezone));
        
        return $timestamp + ($now->getOffset());
        
    }
    
    public static function local_date($client, $format="m/d/Y", $time=null) {
        if (is_numeric($time)) {
            $timestamp = $time;
        }
        elseif(is_string($time)) {
            $timestamp = strtotime($time);
        }  
        else {
            $timestamp = time();
        }
        
        
        $timestamp = self::localTimestamp($client, $time);
        $formatted_date = date($format,$timestamp);
        return $formatted_date;
    }
    
    public static function localTimestamp($client,$time="now") {
        // $timestamp = (is_numeric($time)) ? (is_null($time : strtotime($time);
        
        // $timestamp = (is_numeric($time)) ? (is_null($time : strtotime($time);
        if (is_numeric($time)) {
            $timestamp = $time;
        }
        elseif(is_string($time)) {
            $timestamp = strtotime($time);
        }  
        else {
            $timestamp = time();
        } 
        
        
        // $timestamp = (is_numeric($time)) ? $time : time();
        $timezone = self::localTimezone($client);
        
        // create a date using this 
        $now = new \DateTime(date("m/d/Y g:i:s A", $timestamp), new \DateTimeZone($timezone));
        $gmdate = gmdate("m/d/Y g:i:s A", $timestamp);
        // echo $gmdate;
        $now_gmt = strtotime($gmdate . ' UTC');
        // $now_timestamp = strtotime( strtotime("m/d/y g:i:s A", $time) . ' ' . $timezone, $time);
        // echo '<bR>now: ' .$now->getTimestamp();
        // var_dump($now);
        // echo '<br>offset: ' .($now->getOffset() / 60 / 60);
        // echo '<bR>timestamp:<br>';
        // echo '<bR>now_gmt: ' .$now_gmt;
        return $now_gmt + $now->getOffset();
        
        
    }

    public static function localTimezone($client) {
        
        $gmt_offset = $client->gmt_offset;
        // $gmt_offset = 'UM55';
        $is_um = (substr($gmt_offset, 0, 2) == "UM") ? true : false;
        $hours = substr($gmt_offset, 2,strlen($gmt_offset)-2);
        
        if ($is_um) {
            $hours = -1 * $hours;       
        }   
        
    
        // if a half hour timezone, just take whole number and add 0.5
        if ((strlen($gmt_offset) > 3) && (substr($hours, 1, 1) == 5)) {
            $gmt_offset = substr($gmt_offset, 0, strlen($gmt_offset) - 1);
            $hours = substr($gmt_offset, 2,strlen($gmt_offset)-2);
            $hours += 0.5;
        }
        
        $timeoffset = 3600 * $hours;
        $timezone = timezone_name_from_abbr('', $timeoffset, 0); 
        
        // if we can't find, do a lookup hack
        if ($timezone === false) {
            
            // hack for AU
            $country = ($client->country == 'AU') ? "Australia" : "";
                    
            $abbrarray = timezone_abbreviations_list();
            foreach ($abbrarray as $abbr)
            {
                    foreach ($abbr as $city)
                    {
                            if ($city['offset'] == $timeoffset)
                            {
                                    // take the first one, but only break if closer
                                    $timezone = $city['timezone_id'];
                                    
                                    // more of a hack for AU
                                    if (strpos($city['timezone_id'],$country)) {
                                        break;  
                                    }
                                    
                            }
                    }
            }
     
        }
    
        return $timezone;
    }
  
}