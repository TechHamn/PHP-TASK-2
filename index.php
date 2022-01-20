<!doctype html>
<?php include('request.php');?>
<?php require_once('database.php');?>
<?php
    $db = new DataBase('localhost','dst_workers','root','');
    $urls = $db->getUrls();
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="app.css" rel="stylesheet">
    
    <title>Request URL</title>
  </head>
  <body>
    <h1>Request URL</h1>
    <br>
    <div class="input-group mb-3">
    <form action="" method="post">
    <select class="form-select" id="inputGroupSelect02" name="url">
    <option value="0" selected>Choose...</option>
    <?php foreach($urls as $i => $url):?>   
        <option value="<?php echo $url['id']; ?>"><?php echo $url['url']; ?></option>
    <?php endforeach;?>
    </select>
    <div>
      <br>
        <input type="submit" name="submit" value="Send Request" class="btn btn-outline-primary">
    </div>
    </form>
    <?php
      if(isset($_POST['submit'])){
        if($_POST['url'] && $_POST['url'] != 0){
          $selectedUrlId = $_POST['url'];
          $status = $db->getStatus($selectedUrlId);
          //print_r($status);
          if($status[0]['status'] == "PROCESSING"){
            echo "Cannot execute the Request, Please try in another time";
          } else {
            $url = $status[0]['url'];
            $state = "PROCESSING";
            $db->setStatus($selectedUrlId,$state);
            $respone = urlRequest($url);
            if($respone != "" && $respone == 200){
              $db->updateWorkesInfo($selectedUrlId,'DONE', $respone);
              echo "Request Done";
            }
              elseif($respone != ""){
                $db->updateWorkesInfo($selectedUrlId,'ERROR', $respone);
                echo "Request Failed";
              }
              else {
                $db->updateWorkesInfo($selectedUrlId,'ERROR',null);
                echo "Please Try Again";
              }
          }
        }
        else {
          echo "Please Select One Url";
        }
      }
      ?>

  </body>
</html>
