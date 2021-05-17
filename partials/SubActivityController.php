<?php 

   require_once __DIR__ . './../models/SubActivity.php';

   $subActivity = new SubActivity();

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $subActivity->storeSubActivity($_REQUEST);

   } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $subActivity->deleteSubAct($_REQUEST);

   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      $subActivity->subActIsDone($_REQUEST);

   } else {
      echo 'errore';
   }

   require_once __DIR__ . './DatabaseController.php';
   ?>