<?php 

   require_once __DIR__ . './Database.php';

   class SubActivity extends Database {

      public $id;
      public $title;
      public $activity_id;
      public $done;

      function __construct() {
         $this->dbConnect();
      }

      public function storeSubActivity() {

         $createSubAct = $this->db->prepare("INSERT INTO sub_activities (activity_id, title) VALUES (:activity_id, :title)");

         $createSubAct->bindParam(':activity_id', $this->activity_id);
         $createSubAct->bindParam(':title', $this->title);

         $createSubAct->execute();
      }

      public function deleteSubAct() {

         $deleteSubAct = $this->db->prepare("DELETE FROM sub_activities WHERE id = :id");
         $deleteSubAct->bindParam(':id', $this->id);

         $deleteSubAct->execute();
      }

      public function subActIsDone() {

         $subActIsDone = $this->db->prepare("UPDATE sub_activities SET done = :done WHERE id = :id");
         $subActIsDone->bindParam(':done', $this->done);
         $subActIsDone->bindParam(':id', $this->id);

         $subActIsDone->execute();
      }
   }
?>