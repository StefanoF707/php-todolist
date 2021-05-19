<?php 

   require_once __DIR__ . './../models/SubActivity.php';

   $subActivity = new SubActivity();

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $validation = $subActivity->subActivityValidator();

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {
         $subActivity->storeSubActivity($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';
      }


   } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $subActivity->deleteSubAct($_REQUEST);

   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      $subActivity->subActIsDone($_REQUEST);

   } else {
      echo 'errore';
   }

   ?>