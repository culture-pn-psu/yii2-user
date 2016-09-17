<?php

namespace suPnPsu\user\components;

use Yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Soap {

    public $username = '';
    public $password = '';
    public $userlevel = '';

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
                    'info' => self::UserInfo($ldap),
                ];
                return $result;
            }
            /*
              switch ($this->userlevel) {
              case 4:
              $info = $soapClient->Authenticate($ap_param);
              //p_r($info);
              if ($info->AuthenticateResult) {
              $detail = $soapClient->GetStudentDetails($ap_param);
              //$_SESSION['GetUserDetails'] = $detail->GetStudentDetailsResult->string;
              print_r($detail);
              exit();
              //$this->updateUserField($this->username, "password", md5($password));
              //$this->updateUserField($this->username, "displayname", $_SESSION['GetUserDetails'][0]);
              return 0;
              } else {
              return 2;
              }
              break;

              default:
              $info = $soapClient->Authenticate($ap_param);
              if ($info->AuthenticateResult) {

              $detail = $soapClient->GetUserDetails($ap_param);
              //$_SESSION['GetUserDetails'] = $detail->GetUserDetailsResult->string;
              // Array ( [0] => ahamad.j [1] => อาฮาหมัด [2] => เจ๊ะดือราแม [3] => 0026668 [4] => M [5] => 1949900097921 [6] => D174 [7] => F21 [8] => สถาบันวัฒนธรรมศึกษากัลยาณิวัฒนา [9] => C02 [10] => วิทยาเขตปัตตานี [11] => T01 [12] => นาย [13] => ahamad-j@bunga.pn.psu.ac.th [14] => CN=0026668-ahamad,OU=D174,OU=F21,OU=C02,OU=Staffs,DC=psu,DC=ac,DC=th )
              //print_r($detail);
              echo "<pre>";
              print_r($detail);

              $detail = $soapClient->GetStudentDetails($ap_param);
              //$_SESSION['GetUserDetails'] = $detail->GetStudentDetailsResult->string;
              print_r($detail);

              exit();
              return 0;
              } else {
              return 2;
              }

              break;
              }
             */
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
        }
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