<?php 

   require_once __DIR__ . './../models/Category.php';
   $category = new Category();

   if($_SERVER['REQUEST_METHOD'] === 'POST') {

      $category->storeCategory($_REQUEST);
   } else {
      echo 'errore';
   }

   require_once __DIR__ . './DatabaseController.php';


?>