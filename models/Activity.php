<?php 

   require_once __DIR__ . './../partials/dbSetup.php';

   class Activity extends Database {

      public $id;
      public $project_id;
      public $title;
      public $text;
      public $deadline;
      public $priority;
      public $maker; 
      public $assigned_to;
      public $done;

      function __construct() {
         $this->dbConnect();
      }

      public function storeActivity() {

         $createAct = $this->db->prepare("INSERT INTO activities (project_id, title, text, deadline, priority, maker, assigned_to) VALUES (:project_id, :title, :text, :deadline, :priority, :maker, :assigned_to)");

         $createAct->bindParam(':project_id', $this->project_id);
         $createAct->bindParam(':title', $this->title);
         $createAct->bindParam(':deadline', $this->deadline);
         $createAct->bindParam(':priority', $this->priority);
         $createAct->bindParam(':maker', $this->maker);
         $createAct->bindParam(':assigned_to', $this->assigned_to);
         $createAct->bindParam(':text', $this->text);

         $createAct->execute();
      }

      public function editActivity() {

         $editAct = $this->db->prepare("UPDATE activities SET title = :title, deadline = :deadline, priority = :priority, maker = :maker, assigned_to = :assigned_to, text = :text WHERE id = :id");

         $editAct->bindParam(':title', $this->title);
         $editAct->bindParam(':deadline', $this->deadline);
         $editAct->bindParam(':priority', $this->priority);
         $editAct->bindParam(':maker', $this->maker);
         $editAct->bindParam(':assigned_to', $this->assigned_to);
         $editAct->bindParam(':text', $this->text);
         $editAct->bindParam(':id', $this->id);

         $editAct->execute();

      }

      public function deleteActivity() {
         $deleteAct = $this->db->prepare("DELETE FROM activities WHERE id = :id");
         $deleteAct->bindParam(':id', $this->id);
         $deleteAct->execute();
      }
   }

?>