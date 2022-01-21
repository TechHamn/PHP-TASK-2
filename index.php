
<?php 
/* 
* The main page for running the code
* For running this page on windows, in command prompt run this script: php index.php
* We can run several command prompt in parallel
* Created By Zeinab Moghbel
* On 2022-01-19
*/

  include('request.php');
  require_once('database.php');

  # Conection to database
  $db = new DataBase('localhost','dst_workers','root','');
  $urls = $db->getUrls(); // Get all the URLs in the Database 

  # For each url information in the database
  foreach($urls as $i => $url){
    $urlId = $url['id'];
    $selectedUrl = $url['url'];
    $selectedStatus = $url['status'];
    runRequest($urlId,$selectedUrl,$selectedStatus,$db); // Call the run request
  }

  # This Function call the run request
  function runRequest($urlId,$url,$status,$db){

    if(!empty($url)){

      if($status == "PROCESSING"){
        # If the url request is used by another worker, it Shows us message
        echo "Cannot execute the Request, Please try in another time <br>";
        return;
      } else {

         # Set the status to processing for url request which want to run it at the moment
          $state = "PROCESSING";
          $db->setStatus($urlId,$state);
            
          $respone = urlRequest($url);
          if($respone != "" && $respone == 200){
            $db->updateWorkesInfo($urlId,'DONE', $respone);
              # If request done, show the message 
              echo "Request Done <br>";
              return;
            }
            elseif($respone != ""){
              $db->updateWorkesInfo($urlId,'ERROR', $respone);
              # If request failed, show the message 
                echo "Request Failed <br>";
                return;
              }
              else {
                $db->updateWorkesInfo($urlId,'ERROR',null);
                # If request didn't run, show the message 
                echo "Please Try Again <br>";
              }
              return;
          }
      }
  }
?>
