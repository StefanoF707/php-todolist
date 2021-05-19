<?php 

   require_once __DIR__ . './../models/Category.php';
   $category = new Category();

   if($_SERVER['REQUEST_METHOD'] === 'POST') {

      $validation = $category->categoryValidator($_REQUEST);

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {
         $category->storeCategory($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';
      }

   } else {
      echo 'errore';
   }



?>