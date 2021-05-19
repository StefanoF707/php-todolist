<?php 

   require_once __DIR__ . './../models/Project.php';
   $project = new Project();

   
   if($_SERVER['REQUEST_METHOD'] === 'POST') {

      $validation = $project->projectValidator($_REQUEST);

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {
         $project->storeProject($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';
      }

      
   } elseif($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      $validation = $project->projectValidator($_REQUEST);

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {
         $project->editProject($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';
      }
      
   } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $project->deleteProject($_REQUEST);
      require_once __DIR__ . './DatabaseController.php';

   } else {
      echo 'errore';
   }
   

?>