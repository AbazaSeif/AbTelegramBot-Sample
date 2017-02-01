<?php
setlocale(LC_ALL, 'IND');

  class DateTimeUtil{
    private static $indDays  = Array(
    	'Sun' => 'Minggu',
    	'Mon' => 'Senin',
    	'Tue' => 'Selasa',
    	'Wed' => 'Rabu',
    	'Thu' => 'Kamis',
    	'Fri' => 'Jumat',
    	'Sat' => 'Sabtu'
    );
private static $indMonths = Array (1=>"Januari", 2=>"Pebruari", 3=>"Maret", 4=>"April",
5=>"Mei", 6=>"Juni", 7=>"Juli", 8=>"Agustus", 9=>"September",
10=>"Oktober", 11=>"Nopember", 12=>"Desember");

    public function __construct(){

    }
    public static function convertToDate($stringDate){
      $date = DateTime::createFromFormat('d-m-Y', $stringDate);
      return $date;
    }
    public static function convertToIndDate($stringDate){
      $date = self::convertToDate($stringDate);
      $dayConv = $date->format('D');
      $dayConv = self::removeZeroFirstDate($dayConv);
      $monthConv = $date->format('m');
      $monthConv = self::removeZeroFirstDate($monthConv);
      $dayNumb = $date->format('d');
      $year = $date->format('Y');
      $day = self::$indDays[$dayConv];
      $month = self::$indMonths[$monthConv];
      $dateStr = $day.", ".$dayNumb." ".$month." ".$year;
      return $dateStr;
    }
    private static function removeZeroFirstDate($date){
      if($date[0]==0){
        $date = str_replace("0","",$date);
      }
      return $date;
    }

  }

 ?>
