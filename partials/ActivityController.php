<?php 

   require_once __DIR__ . './../models/Activity.php';

   $activity = new Activity();

   if($_SERVER['REQUEST_METHOD'] === 'POST') {

      $activity->storeActivity($_REQUEST);
   
   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['title'])) {

      $activity->editActivity($_REQUEST);

   } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $activity->deleteActivity($_REQUEST);

   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['done'])) {

      $activity->activityIsDone($_REQUEST);

   } else {
      echo 'errore';
   }
   
   require_once __DIR__ . './DatabaseController.php';

?>