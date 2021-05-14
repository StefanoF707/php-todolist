<?php 

   require_once __DIR__ . './../models/Activity.php';

   $newAct = new Activity();

   if(isset($_GET['title']) && isset($_GET['project_id']) && isset($_GET['deadline']) && isset($_GET['maker']) && isset($_GET['assigned_to']) && isset($_GET['createAct'])) {

      $newAct->title = $_GET['title'];
      $newAct->project_id = $_GET['project_id'];
      $newAct->deadline = $_GET['deadline'];
      $newAct->priority = $_GET['priority'];
      $newAct->maker = $_GET['maker'];
      $newAct->assigned_to = $_GET['assigned_to'];
      $newAct->text = $_GET['text'];
      $newAct->storeActivity();
   
   } elseif (isset($_GET['title']) && isset($_GET['activityId']) && isset($_GET['deadline']) && isset($_GET['maker']) && isset($_GET['assigned_to']) && isset($_GET['editAct'])) {

      $newAct->title = $_GET['title'];
      $newAct->id = $_GET['activityId'];
      $newAct->deadline = $_GET['deadline'];
      $newAct->priority = $_GET['priority'];
      $newAct->maker = $_GET['maker'];
      $newAct->assigned_to = $_GET['assigned_to'];
      $newAct->text = $_GET['text'];

      $newAct->editActivity();
   } elseif (isset($_GET['deleteAct']) && isset($_GET['activityId'])) {

      $newAct->id = $_GET['activityId'];
      $newAct->deleteActivity();

   } elseif (isset($_GET['actDone']) && isset($_GET['actId'])) {

      $newAct->id = $_GET['actId'];
      $newAct->done = $_GET['actDone'];
      $newAct->activityIsDone();

   } else {
      echo 'errore';
   }
   
   require_once __DIR__ . './getData.php';
?>