<?php

  class JadwalBola{
    public $endpointUrl = "http://api.abdymalikmulky.com/v1/bola-jadwal/";
    public $curl;

    function __construct(){
      $this->curl = curl_init();
    }
    function getJadwal($limit=""){
      //list jadwal
      $this->endpointUrl .= "index/";
      //limit
      if(!isset($limit)){
        $this->endpointUrl .= "?limit=".$limit;
      }

      curl_setopt_array($this->curl, array(
        CURLOPT_URL => $this->endpointUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($this->curl);
      $err = curl_error($this->curl);

      $response = json_decode($response, true); //because of true, it's in an array
      return $response;
      curl_close($this->curl);
    }
  }

?>
