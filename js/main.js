let app = new Vue({
   el: '#app',
   data: {
      projectsOpt: {
         newProject: '',
         editInput: false,
         editNameProj: '',
      },
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
      subActivityOpt:{
         newSubActivity: '',
         subActivityDone: false,
      },
      results: [],
      searchResults: {
         projects: [],
         activities: [],
         sub_activities: []
      },
      searchInput: '',
      createNewProj: false,
      showPage: false,
      searchShow: false,
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
               } );
         },
         // Projects

         // Activities

         activityDone(id, actIndex, projIndex) {

            axios
               .get('partials/ActivityController.php', {
                  params: {
                     actDone: this.results[projIndex].activities[actIndex].done == '0' ? '1' : '0',
                     actId: id
                  }
               })
               .then( response => {
                  this.results = response.data;
               } )
         }, 

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
                        priority: this.activityOpt.editActivity.priority ? '0' : '1',
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


         // SubActivities
         subActDone(id, subActIndex, actIndex, projIndex) {
   
            axios
               .get('partials/SubActivityController.php', {
                  params: {
                     subActDone: this.results[projIndex].activities[actIndex].subActivities[subActIndex].done == '0' ? '1' : '0',
                     subActId: id
                  }
               })
               .then( response => {
                  this.results = response.data;
               } )
         },
   
         createNewSubActivity(id) {
   
            if(this.subActivityOpt.newSubActivity != '') {
   
               axios
                  .get('partials/SubActivityController.php', {
                     params: {
                        activity_id: id,
                        subActivityTitle: this.subActivityOpt.newSubActivity,
                     }
                  })
                  .then( response => {
                     this.results = response.data;
                  });
   
               this.subActivityOpt.newSubActivity = '';
            }
         },
   
         deleteSubActivity(id) {
   
            axios
               .get('partials/SubActivityController.php', {
                  params: {
                     subActId: id,
                     deleteSubAct: 1,
                  }
               })
               .then( response => {
                  this.results = response.data;
               } )
         },
         // SubActivities

      // CRUD API


      openActivityEditForm(indexProj, indexAct) {

         this.results.forEach( project => {
            project.activities.forEach( activity => {
               activity.openEditForm = false;
               console.log(activity.openEditForm);
            } )
         } );

         this.results[indexProj].activities[indexAct].openEditForm = true;

         this.activityOpt.editActivity.title = this.results[indexProj].activities[indexAct].title;
         this.activityOpt.editActivity.deadline = this.results[indexProj].activities[indexAct].deadline;
         this.activityOpt.editActivity.priority = this.results[indexProj].activities[indexAct].priority;
         this.activityOpt.editActivity.maker = this.results[indexProj].activities[indexAct].maker;
         this.activityOpt.editActivity.text = this.results[indexProj].activities[indexAct].text;
         this.activityOpt.editActivity.assigned_to = this.results[indexProj].activities[indexAct].assigned_to;
      },

      getSearchData() {

         if(this.searchInput != '') {
            axios
               .get(`partials/DatabaseController.php?inputSearch=${this.searchInput}`)
               .then( response => {
                  this.searchResults = response.data;
                  this.searchShow = true;
               } )
         } else {
            this.searchResults = {
               projects: [],
               activities: [],
               sub_activities: []
            }
         }
      }

   },
   mounted() {
      axios
         .get('partials/DatabaseController.php')
         .then( response => {
            this.results = response.data;
            this.showPage = true;
         } )
   }
});