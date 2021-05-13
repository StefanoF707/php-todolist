<?php 

   require_once __DIR__ . '/dbSetup.php';

   if (isset($_GET['subActivity'])) {

      $subActivity = $_GET['subActivity'];
      $activity_id = $_GET['activity_id'];

      $createSubAct = $db->prepare("INSERT INTO sub_activities (activity_id, title) VALUES (:activity_id, :title)");

      $createSubAct->bindParam(':activity_id', $activity_id);
      $createSubAct->bindParam(':title', $subActivity);

      $createSubAct->execute();

      require_once __DIR__ . './getData.php';
   }
?>