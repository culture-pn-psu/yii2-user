<?php

namespace culturePnPsu\user\components;

use Yii;
use culturePnPsu\user\models\Profile;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Soap {

    public $username = '';
    public $password = '';
    public $id = '';

    public function Authenticate() {
        $soapClient = new \SoapClient('https://passport.psu.ac.th/Authentication/Authentication.asmx?WSDL');
        //SoapClient('https://ca.psu.ac.th/authentication/authentication.asmx?wsdl');

        try {
            $ap_param = array(
                'username' => "{$this->username}",
                'password' => "{$this->password}"
            );

            $info = $soapClient->Authenticate($ap_param);
            if ($info->AuthenticateResult) {

                $detail = $soapClient->GetUserDetails($ap_param);

                $result = [
                    'status' => true,
                    'info' => self::UserInfo($detail->GetUserDetailsResult->string),
                ];
                return $result;
            }
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
        }
    }

    public function UserInfo($detail) {
        
        $data['firstname']=$detail[1];
        $data['lastname']=$detail[2];
        
        
        //Profile::updateProfile($this->id,$data);
        return $data;
        
        
        
        
    }

}

/*
 stdClass Object
(
    [GetUserDetailsResult] => stdClass Object
        (
            [string] => Array
                (
                    [0] => 5620610077
                    [1] => กูดีญานา
                    [2] => นิบือซา
                    [3] => 5620610077
                    [4] => 2
                    [5] => 1949900246233
                    [6] => D217
                    [7] => F36
                    [8] => คณะวิทยาการสื่อสาร คณะวิทยาการสื่อสาร
                    [9] => C02
                    [10] => วิทยาเขตปัตตานี
                    [11] => T02
                    [12] => น.ส.
                    [13] => 5620610077@email.psu.ac.th
                    [14] => CN=5620610077-kudiiana,OU=D217,OU=F36,OU=C02,OU=Students,DC=psu,DC=ac,DC=th
                )

        )

)
stdClass Object
(
    [GetStudentDetailsResult] => stdClass Object
        (
            [string] => Array
                (
                    [0] => 5620610077
                    [1] => กูดีญานา
                    [2] => นิบือซา
                    [3] => 36
                )

        )

) 
 
 */