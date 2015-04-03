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
    public function generate($startDate) {
        $returnICS = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
";
        return $returnICS;
    }

}