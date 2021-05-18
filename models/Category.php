<?php 

   require_once __DIR__ . './Database.php';

   class Category extends Database  {

      function __construct() {
         $this->dbConnect();
      }


      public function storeCategory($request) {

         $createCategory = $this->db->prepare("INSERT INTO categories (category) VALUES (:nameCategory)");
         $createCategory->bindParam(':nameCategory', $request['category']);
         return $createCategory->execute();
         
      }
   }


?>