<?php

    class DatumHelper
    {
        public $datum_value_string;
        public $datum_formated;
        function __construct(){
            
        }

        public function GetDatum($datumString){

            if ($datumString == null){
                return "";
            }
            $this->datum_value_string = $datumString;
            
            $this->datum_formated = new DateTime($this->datum_value_string);
            $this->datum_formated =  $dt = date_format($this->datum_formated, "Y-m-d");

            return $this->datum_formated ;
        }
    }

?>