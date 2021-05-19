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

      /**
       * DB Connect
       * 
       * Inizializza la sessione PDO collegando il db inerente al progetto
       */
      protected function dbConnect() {
         try {
            $this->db = new PDO ("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
         } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
         }
      }


      /**
       * Get Data
       * 
       * Permette di ottenere i dati della tabella indicata
       * 
       * @param $table Stringa che specifica da quale tabella vanno estratti i dati
       * 
       * @return array
       */
      public function getData($table) {

         $getData = $this->db->query("SELECT * FROM $table ORDER BY id DESC");
         $allData = $getData->fetchAll(PDO::FETCH_OBJ);
         return $allData;

      }


      /**
       * Get joined Data
       * 
       * Permette di ottenere i dati tra due tabelle  collegate tra loro
       * 
       * @param $table1, $table2: i nomi delle due tabelle, $record: nome colonna, $fk: nome della colonna foreign key
       * 
       * @return array
       */

      public function getJoinedData($table1, $table2, $record, $fk) {

         $getJoinedData = $this->db->query("SELECT $table1.*, $table2.$record FROM $table1 LEFT JOIN $table2 ON $table1.$fk = $table2.id");
         $allJoinedData = $getJoinedData->fetchAll(PDO::FETCH_OBJ);
         return $allJoinedData;
      }


      /**
       * Get Search Data
       * 
       * Metodo di ricerca in base all'input utente
       * 
       * @param $tableName: nome della tabella, $record: il nome della colonna che si vuole ottenere, $input: Input dell'utente che arriva dal form
       * 
       * @return array
       */
      public function getSearchData($tableName, $record, $input) {

         $getData = $this->db->query("SELECT * FROM $tableName WHERE $record LIKE '%$input%'");
         $allData = $getData->fetchAll(PDO::FETCH_OBJ);
         return $allData;
      }


      public function getNumData($table, $record, $limit) {

         $getNumData = $this->db->query("SELECT $record FROM $table ORDER BY id DESC LIMIT $limit");
         $numData = $getNumData->fetchAll(PDO::FETCH_OBJ);
         return $numData;
      }


   }

?>