<?php 

   require_once __DIR__ . './Database.php';

   class Project extends Database {

      private $name;
      public $id;

      function __construct($name) {
         $this->name = $name;
         $this->dbConnect();
      }

      public function storeProject() {
      
         $createPj = $this->db->prepare("INSERT INTO projects (name) VALUES (:nameProject)");
         $createPj->bindParam(':nameProject', $this->name);
         $createPj->execute();       
      }

      public function editProject() {

         $editPj = $this->db->prepare("UPDATE projects SET name = :nameProject, updated_at=CURRENT_TIMESTAMP WHERE id = :id");
         $editPj->bindParam(':nameProject', $this->name);
         $editPj->bindParam(':id', $this->id);
         $editPj->execute();
      }

      public function deleteProject() {
         $deleteProj = $this->db->prepare("DELETE FROM projects WHERE id = :id");
         $deleteProj->bindParam(':id', $this->id);
         $deleteProj->execute();
      }

   };

?>