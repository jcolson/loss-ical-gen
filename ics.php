<?php
/**
 * Created by PhpStorm.
 * User: jcolson
 * Date: 4/3/15
 * Time: 9:41 AM
 */

class ics {
// Converts a unix timestamp to an ics-friendly format
// NOTE: "Z" means that this timestamp is a UTC timestamp. If you need
// to set a locale, remove the "\Z" and modify DTEND, DTSTAMP and DTSTART
// with TZID properties (see RFC 5545 section 3.3.5 for info)
//
// Also note that we are using "H" instead of "g" because iCalendar's Time format
// requires 24-hour time (see RFC 5545 section 3.3.12 for info).
    function dateToCal($timestamp) {
        return date('Ymd\THis\Z', $timestamp);
    }

// Escapes a string of characters
    function escapeString($string) {
        return preg_replace('/([\,;])/','\\\$1', $string);
    }

    //returns ics for values
    public function generate($startDate, $weight, $loseEachWeek, $targetWeight) {
        $returnICS = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//KARMA LLC//NONSGML loss-ical-gen//EN\r\nCALSCALE:GREGORIAN\r\n";
        $loseEachDay = $loseEachWeek/7;
        $currentDate = strtotime($startDate."-12:00");
        $currentWeight = $weight;
        while ($currentWeight > $targetWeight) {
            $location = "The GYM";
            $uri = "";
            $summary = "Goal: ".round($currentWeight,1);
            $description = $summary;
            $returnICS=$returnICS."BEGIN:VEVENT\r\nDTEND:".$this->dateToCal($currentDate)."\r\nUID:".uniqid()."\r\nDTSTAMP:".$this->dateToCal(time())."\r\nLOCATION:".$this->escapeString($location).
                "\r\nDESCRIPTION:".$this->escapeString($description)."\r\nURL;VALUE=URI:".$this->escapeString($uri).
                "\r\nSUMMARY:".$this->escapeString($summary)."\r\nDTSTART:".$this->dateToCal($currentDate)."\r\nEND:VEVENT\r\n";
            //properly decrement values for next iteration
            $currentDate = strtotime("+1 day",$currentDate);
            $currentWeight = $currentWeight-$loseEachDay;
        }
        $returnICS=$returnICS."END:VCALENDAR\r\n";
        return $returnICS;
    }

}