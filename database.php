<?php
/* 
* This class include databse class, database connection and other function related to database
* Created By Zeinab Moghbel
* On 2022-01-20
*/

    class DataBase {
        private $hostname = 'localhost'; // MySQL Hostname
        private $database; // MySQL Database
        private $username; //MySQL Username
        private $password = ''; //MySQL Password
        public $pdo; //The PDO object

        # set connected value to true if connected
        private $connected = false;


        # constructor
        public function __construct($hostname, $database, $username, $password)
		{ 	
            $this->hostname = $hostname;
            $this->database = $database;
            $this->username = $username;
            $this->password = $password;		
			$this->Connect($hostname, $database, $username, $password);
		}

        # This function for connecting to database
		private function Connect($hostname, $database, $username, $password)
		{
			$dsn = 'mysql:host='.$hostname.';port=3306;dbname='.$database;
			try 
			{
                $pdo = new PDO($dsn,$username,$password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
                $this->connected = true;

			}
			catch (PDOException $e) 
			{echo "2";
                echo 'Connection failed: ' . $e->getMessage();
				//die();
			}
		}

        # This function for getting URLs Info from workers table
        public function getUrls(){
            if(!$this->connected) { $this->Connect($this->hostname,$this->database,$this->username,$this->password); }
            $statemaent = $this->pdo->prepare("SELECT * FROM `workers` ");
            $statemaent->execute();
            $urlsInfo = $statemaent->fetchAll(PDO::FETCH_ASSOC);
            return $urlsInfo;
        }

        # This function for getting status of url thtough url id
        public function getStatus($urlId){
            if(!$this->connected) { $this->Connect($this->hostname,$this->database,$this->username,$this->password); }
            
            $sql = "SELECT url,status FROM workers WHERE id=".$urlId;
            $statemaent = $this->pdo->prepare($sql);
            $statemaent->execute();
            $status = $statemaent->fetchAll(PDO::FETCH_ASSOC);
            return $status;
        }

        # This function for changing status of url in workers table
        public function setStatus($urlId,$status){
            if(!$this->connected) { $this->Connect($this->hostname,$this->database,$this->username,$this->password); }
            $sql = "UPDATE workers SET status = '".$status."' WHERE id=".$urlId;
            $statemaent = $this->pdo->prepare($sql);
            $statemaent->execute();
            $urlsInfo = $statemaent->fetchAll(PDO::FETCH_ASSOC);
            return $urlsInfo;
        }

        # This function for updaying status and http_code of url in workers table
        public function updateWorkesInfo($id,$status,$http_code){
            if(!$this->connected) { $this->Connect($this->hostname,$this->database,$this->username,$this->password); }
            $statemaent = $this->pdo->prepare("UPDATE workers SET status = '".$status."', http_code =". $http_code ." WHERE id=".$id);
            $statemaent->execute();
            $urlsInfo = $statemaent->fetchAll(PDO::FETCH_ASSOC);
            return $urlsInfo;
        }
    }
    
?>
