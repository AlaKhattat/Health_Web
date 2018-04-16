<?php
/**
 * Created by PhpStorm.
 * User: Firassov
 * Date: 04/04/2018
 * Time: 14:56
 */

namespace HealthAdvisorBundle\Entity;


class TokenSymptom
{
    public function getToken()
    {
        $computedHash = base64_encode(hash_hmac ( 'md5' , 'https://authservice.priaid.ch/login' , 'ftHALLrv83JCfdA5', true ));
        $authorization = 'Authorization: Bearer firas_mrad:'.$computedHash;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($curl, CURLOPT_URL, 'https://authservice.priaid.ch/login');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        var_dump($result);
        $obj = json_decode($result);
        $info = curl_getinfo($curl);
        curl_close($curl);

     /*   if($info['http_code'] != '200')
        {
            // print error from the server
            echo($obj);
        }
*/
        return $obj;
    }

}