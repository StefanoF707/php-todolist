<?php 

   require_once __DIR__ . './../models/SubActivity.php';

   $newSubAct = new SubActivity();

   if (isset($_GET['subActivityTitle']) && $_GET['activity_id']) {

      $newSubAct->activity_id = $_GET['activity_id'];
      $newSubAct->title = $_GET['subActivityTitle'];

      $newSubAct->storeSubActivity();

   } elseif(isset($_GET['deleteSubAct']) && isset($_GET['subActId'])) {

      $newSubAct->id = $_GET['subActId'];
      $newSubAct->deleteSubAct();
      
   } elseif (isset($_GET['subActId']) && isset($_GET['subActDone'])) {
      
      $newSubAct->id = $_GET['subActId'];
      $newSubAct->done = $_GET['subActDone'];
      $newSubAct->subActIsDone();

   } else {
      echo 'errore';
   }

   require_once __DIR__ . './getData.php';
   ?>