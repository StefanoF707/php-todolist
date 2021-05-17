<?php 

   require_once __DIR__ . './Database.php';

   class User extends Database {

      function __construct() {
         $this->dbConnect();
      }

      
   }


?>