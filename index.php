<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
   <link rel="stylesheet" href="css/style.css">
   <title>Todo List</title>
</head>
<body>

   <div id="app" v-if="showPage">
      <header>
         <div class="header_search">
            <!-- FORM PROJECT -->
               <input type="text" v-model="projectsOpt.newProject" placeholder="Crea nuovo progetto" @keyup.enter="createNewProject">
            <!-- /FORM PROJECT -->
         </div>
         <div class="header_search">
            <input type="text" placeholder="Cerca">
         </div>
      </header>

      <main>

         <h1 v-if="results.length == 0">La lista dei progetti è vuota</h1>

         <ul v-else id="projects_list">

            <li v-for="(result, index) in results" class="project_item" v-if="results">
               <h3>{{ result.name }}</h3>
               <div class="project_opt">

                  <!-- EDIT DEL PROGETTO -->
                  <i class="fas fa-pencil-alt" @click="projectsOpt.editInput = !projectsOpt.editInput"></i>
                  <input v-if="projectsOpt.editInput" type="text" v-model="projectsOpt.editNameProj" placeholder="modifica nome progetto" @keyup.enter="editProject(result.id)">
                  <!-- /EDIT DEL PROGETTO -->

                  <!-- CANCELLAZIONE DEL PROGETTO -->
                  <i class="fas fa-trash-alt" @click="deleteProject(result.id)"></i>
                  <!-- /CANCELLAZIONE DEL PROGETTO -->

               </div>


               <div class="project_item_bottom">
                  <!-- FORM ACTIVITY -->
                  <div class="create_activity_form">
                     <div class="form_group">
                        <label for="title">Titolo: </label>
                        <input type="text" v-model="activityOpt.newActivity.title" placeholder="Crea nuova attività">
                     </div>
                     <div class="form_group">
                        <label for="deadline">Scadenza: </label>
                        <input type="date" v-model="activityOpt.newActivity.deadline">
                     </div>
                     <div class="form_group">
                        <label for="priority">Priorità: </label>
                        <input type="checkbox" v-model="activityOpt.newActivity.priority">
                     </div>
                     <div class="form_group">
                        <label for="maker">Creatore: </label>
                        <input type="text" v-model="activityOpt.newActivity.maker" placeholder="creatore">
                     </div>
                     <div class="form_group">
                        <label for="assigned_to">Assegnato a: </label>
                        <input type="text" v-model="activityOpt.newActivity.assigned_to" placeholder="assegnato a..">
                     </div>
                     <div class="form_group">
                        <label for="text">Testo: </label>
                        <textarea cols="20" rows="3" v-model="activityOpt.newActivity.text"></textarea>
                     </div>
                     <button @click="createNewActivity(result.id)">Crea</button>
                     <h6 v-if="activityError != ''">{{ activityError }}</h6>
                  </div>
                  <!-- /FORM ACTIVITY -->

                  <ul class="activities_list">
                     <li v-for="(activity, i) in result.activities" class="activity_item"  :class="activity.done == '1' ? 'activity_done' : '' + activity.priority == '1' ? 'urgent' : '' ">
                        <div class="activity_item_left">
                           <i class="fas fa-pencil-alt" @click="openActivityEditForm(index, i)"></i>
                           <i class="fas fa-trash-alt" @click="deleteActivity(activity.id)"></i>
                           <input type="checkbox" @change="activityDone(activity.id, i, index)" :checked="activity.done == '1' ? true : false">
                           <h3>Nome: {{ activity.title }}</h3>
                           <h3>Scadenza: {{ activity.deadline }}</h3>
                           <h4>Creato da: {{ activity.maker }}</h4>
                           <h4>Assegnato a: {{ activity.assigned_to }}</h4>
                        </div>

                        <div class="activity_item_right">
                           <input type="text" v-model="subActivityOpt.newSubActivity" @keyup.enter="createNewSubActivity(activity.id)">
                           <ul class="sub_activities_list">
                              <li v-for="(subAct, subActIndex) in activity.subActivities" class="sub_activity_item" :class="subAct.done == '1' ? 'sub_act_done' : ''">
                                 <p class="sub_activity_item_left">
                                    {{ subAct.title }}
                                 </p>
                                 <div class="sub_activity_item_right">
                                    <input type="checkbox" @change="subActDone(subAct.id, subActIndex, i, index)" :checked="subAct.done == '1' ? true : false">
                                    <i class="fas fa-trash-alt" @click="deleteSubActivity(subAct.id)"></i>
                                 </div>
                              </li>
                           </ul>
                        </div>

                        <div class="activity_item_bottom">
                           <p>{{ activity.text }}</p>
                        </div>

                        <div v-if="activity.openEditForm" class="edit_activity_form">
                           <div class="form_group">
                              <label for="title">Titolo: </label>
                              <input type="text" v-model="activityOpt.editActivity.title" placeholder="Crea nuova attività">
                           </div>
                           <div class="form_group">
                              <label for="deadline">Scadenza: </label>
                              <input type="date" v-model="activityOpt.editActivity.deadline" >
                           </div>
                           <div class="form_group">
                              <label for="priority">Priorità: </label>
                              <input type="checkbox" @change="activityOpt.editActivity.priority = !activityOpt.editActivity.priority" :checked="activity.priority == '1' ? true : false">
                           </div>
                           <div class="form_group">
                              <label for="maker">Creatore: </label>
                              <input type="text" placeholder="creatore" v-model="activityOpt.editActivity.maker">
                           </div>
                           <div class="form_group">
                              <label for="assigned_to">Assegnato a: </label>
                              <input type="text" placeholder="assegnato a..." v-model="activityOpt.editActivity.assigned_to">
                           </div>
                           <div class="form_group">
                              <label for="text">Testo: </label>
                              <textarea cols="20" rows="3" v-model="activityOpt.editActivity.text"></textarea>
                           </div>
                           <button @click="editActivity(activity.id)">Modifica</button>
                        </div>
                     </li>
                  </ul>
               </div>
            </li>
         </ul>

      </main>

   </div>

   

   <script src="js/main.js"></script>
</body>
</html>