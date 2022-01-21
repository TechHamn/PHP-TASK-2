
<?php 

  include('request.php');
  require_once('database.php');

  $db = new DataBase('localhost','dst_workers','root','');
  $urls = $db->getUrls();

  foreach($urls as $i => $url){
    $urlId = $url['id'];
    $selectedUrl = $url['url'];
    $selectedStatus = $url['status'];
    runRequest($urlId,$selectedUrl,$selectedStatus,$db);
  }

  function runRequest($urlId,$url,$status,$db){

    if(!empty($url)){

      if($status == "PROCESSING"){
        echo "Cannot execute the Request, Please try in another time";
        return;
      } else {

          $state = "PROCESSING";
          $db->setStatus($urlId,$state);
            
          $respone = urlRequest($url);
          if($respone != "" && $respone == 200){
            $db->updateWorkesInfo($urlId,'DONE', $respone);
              echo "Request Done <br>";
              return;
            }
            elseif($respone != ""){
              $db->updateWorkesInfo($urlId,'ERROR', $respone);
                echo "Request Failed <br>";
                return;
              }
              else {
                $db->updateWorkesInfo($urlId,'ERROR',null);
                echo "Please Try Again <br>";
              }
              return;
          }
      }
  }
?>