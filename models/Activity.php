<?php 

   require_once __DIR__ . './Database.php';

   class Activity extends Database {

      function __construct() {
         $this->dbConnect();
      }


      /**
       *  Store activity
       * 
       * Crea una nuova attività
       * 
       *  @param array $request  Array arriva dal form
       *  
       * @return bool
       */
      public function storeActivity($request) {

         $createAct = $this->db->prepare("INSERT INTO activities (project_id, category_id, title, text, deadline, priority, maker, assigned_to) VALUES (:project_id, :category_id, :title, :text, :deadline, :priority, :maker, :assigned_to)");

         $createAct->bindParam(':project_id', $request['project_id']);
         $createAct->bindParam(':category_id', $request['category_id']);
         $createAct->bindParam(':title', $request['title']);
         $createAct->bindParam(':deadline', $request['deadline']);
         $createAct->bindParam(':priority', $request['priority']);
         $createAct->bindParam(':maker', $request['maker']);
         $createAct->bindParam(':assigned_to', $request['assigned_to']);
         $createAct->bindParam(':text', $request['text']);

         return $createAct->execute();
      }


      /**
       *  Edit activity
       * 
       * Modifica l'attività esistente
       * 
       *  @param array $request Array arriva dal form
       *  
       * @return bool
       */
      public function editActivity($request) {

         $editAct = $this->db->prepare("UPDATE activities SET title = :title, category_id = :category_id, deadline = :deadline, priority = :priority, maker = :maker, assigned_to = :assigned_to, text = :text WHERE id = :id");

         $editAct->bindParam(':title', $request['title']);
         $editAct->bindParam(':category_id', $request['category_id']);
         $editAct->bindParam(':deadline', $request['deadline']);
         $editAct->bindParam(':priority', $request['priority']);
         $editAct->bindParam(':maker', $request['maker']);
         $editAct->bindParam(':assigned_to', $request['assigned_to']);
         $editAct->bindParam(':text', $request['text']);
         $editAct->bindParam(':id', $request['id']);

         return $editAct->execute();

      }


      /**
       *  Delete activity
       * 
       * Elimina l'attività selezionata dal db
       * 
       *  @param array $request  Array arriva dal form
       *  
       * @return bool
       */
      public function deleteActivity($request) {
         $deleteAct = $this->db->prepare("DELETE FROM activities WHERE id = :id");
         $deleteAct->bindParam(':id', $request['id']);
         return $deleteAct->execute();
      }




      /**
       *  Activity is done
       * 
       * Gestisce il completamento di una determinata attività
       * 
       *  @param array $request  Array arriva dalla chiamata API
       *  
       * @return bool
       */
      public function activityIsDone($request) {

         $actIsDone = $this->db->prepare("UPDATE activities SET done = :done WHERE id = :id");
         $actIsDone->bindParam(':id', $request['id']);
         $actIsDone->bindParam(':done', $request['done']);

         return $actIsDone->execute();
      }
   }

?>