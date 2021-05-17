<?php 

   require_once __DIR__ . './../models/Project.php';
   $project = new Project();

   
   if($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      $project->storeProject($_REQUEST);

      
   } elseif($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      $project->editProject($_REQUEST);
      
   } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      
      $project->deleteProject($_REQUEST);

   } else {
      echo 'errore';
   }
   
   require_once __DIR__ . './DatabaseController.php';
   

?>