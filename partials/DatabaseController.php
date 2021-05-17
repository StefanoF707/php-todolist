<?php 

   require_once __DIR__ . './../models/Database.php';

   $db = new Database();

   if (isset($_GET['inputSearch'])) {

      $searchResults = [];

      $searchResults['projects'] = $db->getSearchData('projects', 'name', $_GET['inputSearch']);
      $searchResults['activities'] = $db->getSearchData('activities', 'title', $_GET['inputSearch']);
      $searchResults['sub_activities'] = $db->getSearchData('sub_activities', 'title', $_GET['inputSearch']);

      echo json_encode($searchResults);
      

   } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['users'])) {

      $allUsers = $db->getData('users');
      
      echo json_encode($allUsers);
   }  else {

      $allProjects = $db->getData('projects');
      $allActivities = $db->getData('activities');
      $allSubActivities = $db->getData('sub_activities');
      

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
   }



?>