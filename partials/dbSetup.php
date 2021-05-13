<?php 

   class Database {
      protected $db;
      private $servername = 'localhost';
      private $username = 'root';
      private $password = 'root';
      private $dbname = 'db-todolist';

      protected function dbConnect() {
         try {
            $this->db = new PDO ("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
         } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
         }
      }
   }

?>