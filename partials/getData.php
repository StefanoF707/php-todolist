<?php 

   try {
      $servername = 'localhost';
      $username = 'root';
      $password = 'root';
      $dbname = 'db-todolist';

      $db = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);

   } catch (PDOException $e) {
      echo "Errore: " . $e->getMessage();
      die();
   }

   $getAllProjects = $db->query("SELECT * FROM projects ORDER BY `id` DESC");
   $getAllActivities = $db->query("SELECT * FROM activities");
   $getAllSubActivities = $db->query("SELECT * FROM sub_activities");

   $allProjects = $getAllProjects->fetchAll(PDO::FETCH_OBJ);
   $allActivities = $getAllActivities->fetchAll(PDO::FETCH_OBJ);
   $allSubActivities = $getAllSubActivities->fetchAll(PDO::FETCH_OBJ);

   foreach($allProjects as $project) {
      $project->activities = [];

      foreach($allActivities as $activity) {

         $activity->subActivities = [];

         if($project->id == $activity->project_id) {
            $project->activities[] = $activity;
         }

         foreach($allSubActivities as $subActivity) {

            if($activity->id == $subActivity->activity_id) {
               $activity->subActivities[] = $subActivity;
            }
         }

      }

   }


   echo json_encode($allProjects);


?>