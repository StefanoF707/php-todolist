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
         $data = $project->getNewestData('projects');
         echo json_encode($data);
      }

      
   } elseif($_SERVER['REQUEST_METHOD'] === 'GET') {
      
      $validation = $project->projectValidator($_REQUEST);

      if (is_array($validation)) {
         echo json_encode($validation);
         http_response_code(206);
      } else {

         $project->editProject($_REQUEST);

         $projectData = $project->getEditedData('projects', $_REQUEST['id']);
         $activitiesData = $project->getSubData('activities', 'project_id', $_REQUEST['id']);

         foreach($activitiesData as $activity) {
            $projectData->activities[] = $activity;

            $subActData = $project->getSubData('sub_activities', 'activity_id', $activity->id);
            foreach($subActData as $subAct) {
               $activity->subActivities[] = $subAct;
            }

            $categoryData = $project->getNumData('categories');
         }

         echo json_encode($projectData);
      }
      
   } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {

      $project->deleteProject($_REQUEST);
      require_once __DIR__ . './DatabaseController.php';

   } else {
      echo 'errore';
   }
   

?>