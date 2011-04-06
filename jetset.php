<?php

date_default_timezone_set('GMT');

function parse_locations($itinerary) {
  $locations = array(
    'next'    => null,
    'current' => null,
    'last'    => null,

    'future' => array(),
    'past'   => array()
  );
  
  krsort($itinerary);

  foreach($itinerary as $date => $location) {
    $location = array('date' => $date, 'place' => $location);

    if ($date > time()) {
      $locations['future'][] = $location;
    } else if (!$locations['current']) {
      $locations['next'] = array_pop($locations['future']);
      $locations['current'] = $location;      
    } else if (!$locations['last']) {
      $locations['last'] = $location;
    } else {
      $locations['past'][] = $location;
    }
  }
  
  $locations['future'] = array_reverse($locations['future']);
    
  return $locations;
}

# Thanks for the head start, Marco
# (http://www.marco.org/46559003)
function relative_date($date) {
  $seconds = time() - intval($date);
  $future = $seconds < 0;
  $seconds = abs($seconds);

  $units = array(
    31536000 => 'year',
    2592000 => 'month',
    604800  => 'week',
    86400   => 'day'
  );

  foreach ($units as $max => $unit) {
    if ($seconds < $max) continue;
    
    $num = floor($seconds / $max);
    
    if ($num == 1) {
      if ($future) {
        $format = 'next %s';
      } else {
        $format = 'last %s';
      }
    } else {
      $unit = pluralize($num, $unit);

      if ($future) {
        $format = 'in %s';
      } else {
        $format = '%s ago';
      }
    }
    
    $string = sprintf($format, $unit);
    
    break;
  }
  
  if ($string == 'next day') {
    $string = 'tomorrow';
  } else if ($string == 'last day') {
    $string = 'yesterday'; 
  }
  
  return $string;
}

# This is Marco's too. Same place.
function pluralize($number, $noun, $nouns = false) {
  if (!$nouns) $nouns = $noun . 's';
  return $number . ' ' . ($number == 1 ? $noun : $nouns);
}