<?php 

   class Database {
      protected $db;
      private $servername = 'localhost';
      private $username = 'root';
      private $password = 'root';
      private $dbname = 'db-todolist';

      function __construct() {
         $this->dbConnect();
      }

      protected function dbConnect() {
         try {
            $this->db = new PDO ("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
         } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
         }
      }

      public function getData($table) {

         $getData = $this->db->query("SELECT * FROM $table");
         $allData = $getData->fetchAll(PDO::FETCH_OBJ);
         return $allData;

      }

      public function getSearchData($tableName, $record, $input) {

         $dataArray = [];

         $getData = $this->db->query("SELECT $record FROM $tableName WHERE $record LIKE '%$input%'");
         $allData = $getData->fetchAll(PDO::FETCH_NUM);
         foreach($allData as $data) {
            $dataArray[] = $data[0];
         }
         return $dataArray;
      }


   }

?>