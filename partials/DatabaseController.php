<?php 

   require_once __DIR__ . './../models/Database.php';

   $db = new Database();

   if (isset($_GET['inputSearch'])) {

      $allProjects = $db->getSearchData('projects', 'name', $_GET['inputSearch']);
      $allActivities = $db->getSearchData('activities', 'title', $_GET['inputSearch']);
      $allSubActivities = $db->getSearchData('sub_activities', 'title', $_GET['inputSearch']);

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
      

   } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['users'])) {

      $allUsers = $db->getData('users');
      
      echo json_encode($allUsers);
   }  else {

      $allProjects = $db->getData('projects');
      $allActivities = $db->getJoinedData('activities', 'categories', 'category', 'category_id');
      $allSubActivities = $db->getData('sub_activities');
      $allCategories = $db->getData('categories');


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

      $data = [
         "results" => $allProjects,
         "categories" => $allCategories,
      ];

      echo json_encode($data);
   }



?>