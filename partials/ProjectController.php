<?php 

   require_once __DIR__ . './../models/Project.php';

   if(isset($_GET['newProject'])) {
      
      $newProject = new Project($_GET['newProject']);
      $newProject->storeProject();

      
   } elseif(isset($_GET['editProj']) && isset($_GET['idProj'])) {
      
      $editProject = new Project($_GET['editProj']);
      $editProject->id = $_GET['idProj'];
      $editProject->editProject();
      
   } elseif(isset($_GET['deleteProj']) && isset($_GET['idProj'])) {
      
      $deleteProject = new Project($_GET['deleteProj']);
      $deleteProject->id = $_GET['idProj'];
      $deleteProject->deleteProject();
      
   } else {
      echo 'errore';
   }
   
   require_once __DIR__ . './getData.php';
   

?>