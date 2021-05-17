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
       * Permette di ottenere i dati di ogni tabella dal db
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
       * Get Search Data
       * 
       * Metodo di ricerca in base all'input utente
       * 
       * @param $tableName: nome della tabella, $record: il nome della colonna che si vuole ottenere, $input: Input dell'utente che arriva dal form
       * 
       * @return array
       */
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