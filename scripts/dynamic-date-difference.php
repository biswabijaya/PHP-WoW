<?php

/* Function Parameters
  $date1 = strtotime("2019-01-01 00:00:00") or strtotime(date("Y-m-d H:i:s")) or time()
  $date2 = strtotime("2019-12-31 23:59:59") or strtotime(date("Y-m-d H:i:s")) or time()
  $format = 'Y' or 'M' or 'D' or 'H' or 'i' or 'S'
*/

/* Sample Usage
  $date1 = strtotime("2019-01-01 00:00:00"); //from 2019 year beginning
  $date2 = time(); //current time
  $format = 'M'; // Printing in Month Days Hour Minute Second
  echo dateDiff($date1,$date2,$format);
*/

function dateDiff($date1,$date2,$format='D'){
  $diff = abs($date2 - $date1);
  $year=$months=$days=$hours=$minutes=$seconds=0;
  $print="";

  switch($format){
    case 'Y':
      $years = floor($diff / (365*60*60*24));
      $print.= $years." years ";
    case 'M':
      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
      $print.= $months." months ";
    case 'D':
      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
      $print.= $days." days ";
    case 'H':
      $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
      $print.= $hours." hours ";
    case 'i':
      $minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
      $print.= $minutes." minutes ";
    case 's':
      $seconds = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
      $print.= $seconds." seconds ";
  }
  return $print;
}


?>
