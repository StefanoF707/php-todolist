<?php 

   require_once __DIR__ . './Database.php';

   class Project extends Database {

      
      function __construct() {
         $this->dbConnect();
      }


      /**
       * Project Validator
       * 
       * Gestisce la validazione dei dati per la creazione di un nuovo progetto
       * 
       * @param $request: i dati provenienti dalla chaiamta axios
       * 
       * @return bool|array
       */
      public function projectValidator($request) {
         $errors = [];

         if ($request['name'] == "") {
            $errors[] = 'Il nome del progetto non può essere vuoto';
         }

         if (count($errors) == 0) {
            return true;
         } else {
            return $errors;
         }
      }


      /**
       * Store projects
       * 
       * Crea un nuovo progetto
       * 
       * @param array $request contiene i dati provenienti dalla chiamata API
       * 
       * @return bool
       */
      public function storeProject($request) {

            $createPj = $this->db->prepare("INSERT INTO projects (name) VALUES (:nameProject)");
            $createPj->bindParam(':nameProject', $request['name']);
            return $createPj->execute();
      
      }


      /**
       * Edit projects
       * 
       * Modifica il progetto esistente
       * 
       * @param array $request contiene i dati provenienti dalla chiamata API
       * 
       * @return bool
       */
      public function editProject($request) {

         $editPj = $this->db->prepare("UPDATE projects SET name = :nameProject, updated_at=CURRENT_TIMESTAMP WHERE id = :id");
         $editPj->bindParam(':nameProject', $request['name']);
         $editPj->bindParam(':id', $request['id']);
         return $editPj->execute();
      }


       /**
       * Delete projects
       * 
       * Elimina il progetto esistente
       * 
       * @param array $request contiene i dati provenienti dalla chiamata API
       * 
       * @return bool
       */
      public function deleteProject($request) {
         $deleteProj = $this->db->prepare("DELETE FROM projects WHERE id = :id");
         $deleteProj->bindParam(':id', $request['id']);
         return $deleteProj->execute();
      }

   };

?>