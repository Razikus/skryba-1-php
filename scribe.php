<?php

class ScribeClient {
    private $login;
    private $password;
    private $url;


    public function __construct($url, $login, $password) {
        $this->login = $login;
        $this->password = $password;
        $this->url = $url;
    }

    private function prepareCurl($for) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/" . $for);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->login . ":" . $this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return $ch;
    }

    public function getRecordsInDay($day) {
        $ch = $this->prepareCurl("day");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array (
            "day" => $day,
            "genType" => "csv",
            "present" => "all"
        ));

        $output = curl_exec($ch);
        $csvFirst = str_getcsv($output, "\n");
        curl_close($ch);
        $parsed = array();

        foreach ($csvFirst as &$value) {
            array_push($parsed, str_getcsv($value));
        }
        array_shift($parsed);
        return $parsed; 
    }

    public function getRecordsInPeriod($from, $to, $rfidID="", $user="") {
        $ch = $this->prepareCurl("custom");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array (
            "yearmonth" => $from,
            "yearmonth2" => $to,
            "rfidID" => $rfidID,
            "user" => $user,
            "genType" => "csv",
            "present" => "all"
        ));

        $output = curl_exec($ch);
        $csvFirst = str_getcsv($output, "\n");
        curl_close($ch);
        $parsed = array();

        foreach ($csvFirst as &$value) {
            array_push($parsed, str_getcsv($value));
        }
        array_shift($parsed);
        return $parsed; 
    }

    public function getBackup() {
        $ch = $this->prepareCurl("backup");

        $output = curl_exec($ch);
        return $output;
    }

}

?>