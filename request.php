
<?php

function urlRequest($url){

    $info = ""; // For inserting http code

    if(!empty($url)){  

        $resoure = curl_init($url);

        curl_setopt($resoure,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($resoure, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($resoure, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($resoure, CURLOPT_TIMEOUT, 80);

        $result = curl_exec($resoure);

        $info = curl_getinfo($resoure,CURLINFO_HTTP_CODE);
                
        if(curl_error($resoure)){
            echo 'Request Error:' . curl_error($resoure);
        }
        else{
            //var_dump($result);
            //var_dump($info);
        }

        curl_close($resoure);
    }
    return $info;
}

?>
