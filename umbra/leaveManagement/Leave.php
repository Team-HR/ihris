<?php

/* ================================================================================================================================
    @CLASS
        @ORIGINS
            VL = vacation leave


================================================================================================================================
================================================================================================================================ 
    @var
        @PROTECTED
            dat = an array of data from the form

        @PRIVATE
            applied_dates = array of date when to apply the leave
                            array format:
                                    applied_dates = [date,date,date]
            file_date = filing date of the applicant
        
        @PUBLIC


    
    
    
================================================================================================================================*/

class Leave extends mysqli
{
    protected $dat = [];

    private $applied_dates = [];
    private $file_date;
    

    public function __construct($ar){
        $this -> dat = $ar;
        $this->prepare_properties();
    }
    private function prepare_properties(){
        $this->applied_dates = $this->dat['applied_dates'];
        $this->file_date = $this->dat['file_date'];
    }


    private function VL(){
        $invalid = 0;
        $applied_dates = $this->applied_dates;
        $valid = true;
        foreach ($applied_dates as $date ){
            $filed = new DateTime($this->file_date);
            $applied = new DateTime($date);
            $count = $filed->diff($applied);
            if($count>5){
                $valid = false;
                break;
            }
        }

        if($valid){




            echo "valid";
        }else{
            echo "invalid";
        }

    }



    private function VLWP(){

    }




}








/* 
    @leadProgrammer: Franz Joshoa Valencia
    @author : Pascual Tomulto
    @author : Vanessa Arocha
    @copyright: 2020 pioneers 
    @version:1.00






*/



?>