<?php
/* 
* This Function For running the url Request
* Created By Zeinab Moghbel
* On 2022-01-19
*/

function urlRequest($url){

    $info = ""; // For inserting http code

    if(!empty($url)){  

        #initial CURL Request
        $resoure = curl_init($url);

        #Set CURL Options
        curl_setopt($resoure,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($resoure, CURLOPT_SSL_VERIFYPEER, FALSE); // SSL is Based on Conditions, In some Systems version = 3 or 4 maybe work better
        curl_setopt($resoure, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($resoure, CURLOPT_TIMEOUT, 80); // maximum time the transfer is allowed to complete 

        $result = curl_exec($resoure);

        $info = curl_getinfo($resoure,CURLINFO_HTTP_CODE);
                
        if(curl_error($resoure)){
            echo 'Request Error:' . curl_error($resoure); //In case of Error print the error
        }
        else{
            //var_dump($result);
            //var_dump($info);
        }

        # Prior to PHP 8.0.0, this function was used to close the resource. 
        curl_close($resoure);
    }
    return $info;
}

?>
