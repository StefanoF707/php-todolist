<?php 

   require_once __DIR__ . './../models/Activity.php';


   if(isset($_GET['title']) && isset($_GET['project_id']) && isset($_GET['deadline']) && isset($_GET['maker']) && isset($_GET['assigned_to']) && isset($_GET['createAct'])) {

      $newAct = new Activity();
      $newAct->title = $_GET['title'];
      $newAct->project_id = $_GET['project_id'];
      $newAct->deadline = $_GET['deadline'];
      $newAct->priority = $_GET['priority'];
      $newAct->maker = $_GET['maker'];
      $newAct->assigned_to = $_GET['assigned_to'];
      $newAct->text = $_GET['text'];

      $newAct->storeActivity();
   
   } elseif (isset($_GET['title']) && isset($_GET['activityId']) && isset($_GET['deadline']) && isset($_GET['maker']) && isset($_GET['assigned_to']) && isset($_GET['editAct'])) {

      $editAct = new Activity();
      $editAct->title = $_GET['title'];
      $editAct->id = $_GET['activityId'];
      $editAct->deadline = $_GET['deadline'];
      $editAct->priority = $_GET['priority'];
      $editAct->maker = $_GET['maker'];
      $editAct->assigned_to = $_GET['assigned_to'];
      $editAct->text = $_GET['text'];

      $editAct->editActivity();
   } elseif (isset($_GET['deleteAct']) && isset($_GET['activityId'])) {

      $deleteAct = new Activity();
      $deleteAct->id = $_GET['activityId'];

      $deleteAct->deleteActivity();
   } else {
      echo 'errore';
   }
   
   require_once __DIR__ . './getData.php';
?>