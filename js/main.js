let app = new Vue({
   el: '#app',
   data: {
      activityOpt: {
         newActivity: {
            title: '',
            deadline: '',
            priority: false,
            maker: '',
            text: '',
            assigned_to: '',
         },
         editActivity: {
            title: '',
            deadline: '',
            priority: false,
            maker: '',
            text: '',
            assigned_to: '',
         },
      },
      projectsOpt: {
         newProject: '',
         editInput: false,
         editNameProj: '',
      },
      newSubActivity: '',
      searchInput: '',
      projectError: '',
      activityError: '',
      results: [],
      createNewProj: false,
      showPage: false,
   },
   methods: {

      // CRUD API

         // Projects

      createNewProject() {
         if (this.projectsOpt.newProject != '') {
 
            axios
            .get('partials/ProjectController.php', {
                  params: {
                     newProject: this.projectsOpt.newProject
                  }
               })
               .then( response => {
                  this.results = response.data;
               });

               this.projectError = '';
               this.projectsOpt.newProject = '';
               this.createNewProj = false;
         } else {
            this.projectError = 'Questo campo non può essere vuoto';
         }
      },

      editProject(id) {

         if(this.projectsOpt.editNameProj != '') {

            axios
               .get('partials/ProjectController.php', {
                  params: {
                     editProj: this.projectsOpt.editNameProj,
                     idProj: id,
                  }
               })
               .then( response => {
                  this.results = response.data;
               } );

               this.projectsOpt.editNameProj = '';
               this.projectsOpt.editinput = false;
         }
      },

      deleteProject(id) {

         axios
            .get('partials/ProjectController.php', {
               params: {
                  deleteProj: 1,
                  idProj: id,
               }
            })
            .then( response => {
               this.results = response.data;
            } )
      },

         // Projects

         // Activities
         createNewActivity(id) {
            if (this.activityOpt.newActivity.title != '' && this.activityOpt.newActivity.deadline != '' && this.activityOpt.newActivity.maker != '' && this.activityOpt.newActivity.assigned_to != '') {
   
               this.activityError = '';
   
               axios
                  .get('partials/ActivityController.php', {
                     params: {
                        title: this.activityOpt.newActivity.title,
                        project_id: id,
                        deadline: this.activityOpt.newActivity.deadline,
                        priority: this.activityOpt.newActivity.priority ? '1' : '0',
                        maker: this.activityOpt.newActivity.maker,
                        assigned_to: this.activityOpt.newActivity.assigned_to,
                        text: this.activityOpt.newActivity.text,
                        createAct: 1,
                     }
                  })
                  .then( response => {
                     this.results = response.data;
                  } );
   
                  this.activityOpt.newActivity.title = '';
                  this.activityOpt.newActivity.deadline = '';
                  this.activityOpt.newActivity.maker = '';
                  this.activityOpt.newActivity.priority = false;
                  this.activityOpt.newActivity.assigned_to = '';
                  this.activityOpt.newActivity.text = '';
            } else {
               this.activityError = 'Riempire tutti i campi'
            }
   
         },
   
         editActivity(id) {
            if (this.activityOpt.editActivity.title != '' && this.activityOpt.editActivity.deadline != '' && this.activityOpt.editActivity.maker != '' && this.activityOpt.editActivity.assigned_to != '') {
   
               axios
                  .get('partials/ActivityController.php', {
                     params: {
                        title: this.activityOpt.editActivity.title,
                        activityId: id,
                        deadline: this.activityOpt.editActivity.deadline,
                        priority: this.activityOpt.editActivity.priority ? '1' : '0',
                        maker: this.activityOpt.editActivity.maker,
                        assigned_to: this.activityOpt.editActivity.assigned_to,
                        text: this.activityOpt.editActivity.text,
                        editAct: 1,
                     }
                  })
                  .then( response => {
                     this.results = response.data;
                  } );
            }
         },

         deleteActivity(id) {

            axios.get('partials/ActivityController.php', {
               params: {
                  deleteAct: 1,
                  activityId: id
               }
            }).then( response => {
               this.results = response.data;
            } )
         },


         // Activities


      // CRUD API



      createNewSubActivity(id) {

         if(this.newSubActivity != '') {

            axios
               .get('partials/createSubActivity.php', {
                  params: {
                     activity_id: id,
                     subActivity: this.newSubActivity,
                  }
               })
               .then( response => {
                  this.results = response.data;
               });

            this.newSubActivity = '';
         }
      },

      openActivityEditForm(indexProj, indexAct) {

         this.results.forEach( project => {
            project.activities.forEach( activity => {
               activity.openEditForm = false;
               console.log(activity.openEditForm);
            } )
         } );

         this.results[indexProj].activities[indexAct].openEditForm = true;

         console.log(this.results[indexProj].activities[indexAct].openEditForm = true);

         this.activityOpt.editActivity.title = this.results[indexProj].activities[indexAct].title;
         this.activityOpt.editActivity.deadline = this.results[indexProj].activities[indexAct].deadline;
         this.activityOpt.editActivity.priority = this.results[indexProj].activities[indexAct].priority;
         this.activityOpt.editActivity.maker = this.results[indexProj].activities[indexAct].maker;
         this.activityOpt.editActivity.text = this.results[indexProj].activities[indexAct].text;
         this.activityOpt.editActivity.assigned_to = this.results[indexProj].activities[indexAct].assigned_to;
      }

   },
   mounted() {
      axios
         .get('partials/getData.php')
         .then( response => {
            this.results = response.data;
            this.showPage = true;
         } )
   }
});