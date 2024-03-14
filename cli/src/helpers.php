<?php
/**
 * Helper functions
 */

// Get the current timestamp
function current_timestamp() {
    $currentTimestamp = time(); // Get the current timestamp (UNIX timestamp)

    // Convert the timestamp to a string with a specific format
    $timestampString = date('Y-m-d H:i:s', $currentTimestamp);
    return $timestampString;
}

// Get the current date
function current_date() {
    $currentTimestamp = time(); // Get the current timestamp (UNIX timestamp)

    // Convert the timestamp to a string with a specific format
    $dateString = date('Y-m-d', $currentTimestamp);
    return $dateString;
}

// Check if a string is JSON
function is_json($string) {
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

// Generate dates from range with a specific format and step of 1 day
function dates_from_range($start, $end, $format='Y-m-d') {
    if ($start == $end) {
        return array($start);
    }
    return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
    },
    range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
}

// Check if a string is a date
function is_date($date) {
    if (is_null($date)) {
        return false;
    }
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
