<?php 

   require_once __DIR__ . './Database.php';

   class Activity extends Database {

      function __construct() {
         $this->dbConnect();
      }

      /**
       * Validate date
       * 
       * Permette di effettuare la validazione del campo data nel formato che arriva tramite la chiamata axios
       * 
       * @param $date: ILa data che si vuole validare, $format: campo di default che setta il formato utile a validare la data
       * 
       * @return bool
       */
      protected function validateDate($date, $format = 'Y-m-d H:i:s')
      {
         $d = DateTime::createFromFormat($format, $date);
         return $d && $d->format($format) == $date;
      }


      /**
       * Activity Validator
       * 
       * Gestisce la validazione dei dati per la creazione di una nuova attività
       * 
       * @param $request: i dati provenienti dalla chaiamta axios
       * 
       * @return bool|array
       */
      public function activityValidator($request) {

         $errors = [];

         if ($request['title'] == "") {
            $errors[] ="Il nome dell'attività non può essere vuoto";
         }

         if (strlen($request['title']) > 45) {
            $errors[] ="Il nome dell'attività può avere massimo 45 caratteri";
         }

         
         if (!$this->validateDate($request['deadline'], 'Y-m-d')) {
            $errors[] = 'La data inserita non è valida';
         }
         
         if (date("Y-m-d") > $request['deadline']) {
            $errors[] = "Inserire una data successiva a quella corrente";
         }

         if ($request['assigned_to'] == "") {
            $errors[]= 'Assegnare il task a qualcuno';
         }

         if (count($errors) == 0) {
            return true;
         } else {
            return $errors;
         }

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