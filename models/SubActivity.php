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


      /**
       * Category Validator
       * 
       * Gestisce la validazione dei dati per la creazione di una suova sotto-attività
       * 
       * @param $request: i dati provenienti dalla chaiamta axios
       * 
       * @return bool|array
       */
      public function subActivityValidator($request) {

         $errors = [];

         if ($request['title'] == '') {
            $errors[] = 'Il nome della sottoattività non può essere vuoto';
         }

         if (strlen($request['title']) > 45) {
            $errors[] = 'Il nome della sottoattività può avere massimo 45 caratteri';
         }

         if(count($errors) == 0) {
            return true;
         } else {
            return $errors;
         }
      }


      /**
       * Store SubActivity
       * 
       * Permette di salvare una nuova sotto-attività
       * 
       * @param $request: I dati che arrivano dal form
       * 
       * @return bool
       */

      public function storeSubActivity($request) {

         $createSubAct = $this->db->prepare("INSERT INTO sub_activities (activity_id, title) VALUES (:activity_id, :title)");

         $createSubAct->bindParam(':activity_id', $request['activity_id']);
         $createSubAct->bindParam(':title', $request['title']);

         return $createSubAct->execute();
      }



      /**
       * Delete SubActivity
       * 
       * Permette di eliminare una sotto-attività esistente
       * 
       * @param $request: I dati che arrivano dal form
       * 
       * @return bool
       */
      public function deleteSubAct($request) {

         $deleteSubAct = $this->db->prepare("DELETE FROM sub_activities WHERE id = :id");
         $deleteSubAct->bindParam(':id', $request['id']);

         return $deleteSubAct->execute();
      }


      /**
       * SubActivity is done
       * 
       * Permette di gestire il completamente di una sotto-attività
       * 
       * @param $request: I dati che arrivano dal form
       * 
       * @return bool
       */
      public function subActIsDone($request) {

         $subActIsDone = $this->db->prepare("UPDATE sub_activities SET done = :done WHERE id = :id");
         $subActIsDone->bindParam(':done', $request['done']);
         $subActIsDone->bindParam(':id', $request['id']);

         return $subActIsDone->execute();
      }
   }
?>