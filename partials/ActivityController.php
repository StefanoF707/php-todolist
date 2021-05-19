<?php 

   require_once __DIR__ . './../models/Activity.php';

   $activity = new Activity();

   if($_SERVER['REQUEST_METHOD'] === 'POST') {

      $validation = $activity->activityValidator($_REQUEST);

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {

         if ($_REQUEST['category_id'] == "") {
            $data = $activity->getNumData('categories', 'id', 1);
            $_REQUEST['category_id'] = $data[0]->id;
         }
   
         $activity->storeActivity($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';

      }

   
   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['title'])) {

      $validation = $activity->activityValidator($_REQUEST);
      
      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {
         $activity->editActivity($_REQUEST);
         require_once __DIR__ . './DatabaseController.php';
      }

   } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $activity->deleteActivity($_REQUEST);
      require_once __DIR__ . './DatabaseController.php';


   } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['done'])) {

      $activity->activityIsDone($_REQUEST);
      require_once __DIR__ . './DatabaseController.php';

   } else {
      echo 'errore';
   }
   
?>