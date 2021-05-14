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

   


?>