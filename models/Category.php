<?php 

   require_once __DIR__ . './Database.php';

   class Category extends Database  {

      function __construct() {
         $this->dbConnect();
      }

      /**
       * Category Validator
       * 
       * Gestisce la validazione dei dati per l'assegnazione di una determinata categoria a un'attività
       * 
       * @param $request: i dati provenienti dalla chaiamta axios
       * 
       * @return bool|array
       */
      public function categoryValidator($request) {

         $errors = [];

         if ($request['category'] == "") {
            $errors[] = 'Inserire una categoria esistente o crearne una nuova';
         }

         if (count($errors) == 0) {
            return true;
         } else {
            return $errors;
         }
      }


      /**
       * Store Category
       * 
       * Permette di  creare una nuova categoria
       * 
       * @param $request: i dati che arrivano dal campo di input
       * 
       * @return bool
       */
      public function storeCategory($request) {

         $createCategory = $this->db->prepare("INSERT INTO categories (category) VALUES (:nameCategory)");
         $createCategory->bindParam(':nameCategory', $request['category']);
         return $createCategory->execute();

      }
   }


?>