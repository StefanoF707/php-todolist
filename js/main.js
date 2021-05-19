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
            text: '',
            assigned_to: '',
            category_id: "-",
         },
         editActivity: {
            title: '',
            deadline: '',
            priority: false,
            text: '',
            assigned_to: '',
            category_id: "-",
         },
      },
      subActivityOpt:{
         newSubActivity: '',
         subActivityDone: false,
      },
      results: [],
      users:[],
      categories: [],
      userLogged: '',
      searchResults: [],
      massiveActivities: [],
      searchInput: '',
      createNewProj: false,
      showPage: false,
      searchShow: false,
      massiveFormOpen: false,
      createCategory: false,
      newCategory: "",
      errors: [],
   },
   methods: {

      // CRUD API

         createNewCategory() {

            if (this.newCategory != "") {

               let bodyFormData = new FormData();
               bodyFormData.append('category', this.newCategory);

               axios({
                  method: "post",
                  url: "./partials/CategoryController.php",
                  data: bodyFormData,
                  headers: {"Content-Type": "multipart/form-data" },
               })
                  .then( response => {

                     if (response.status === 200) {
                        this.errors =[];
                        this.results = response.data.results;
                        this.categories = response.data.categories;
                     } else {
                        response.data.forEach( error => {
                           this.errors.push(error);
                        } );
                     }

                  } )

               this.newCategory = "";

            }
         },

         // Projects
         createNewProject() {
            if (this.projectsOpt.newProject != '') {

                  let bodyFormData = new FormData();
                  bodyFormData.append('name', this.projectsOpt.newProject);

                  axios({
                     method: 'post',
                     url: './partials/ProjectController.php',
                     data: bodyFormData,
                     headers: { "Content-Type": "multipart/form-data" },
                   })
                     .then( response => {

                        if (response.status === 200) {
                           this.errors =[];
                           this.results = response.data.results;
                           this.categories = response.data.categories;
                        } else {
                           this.errors = response.data;
                        }
                     });
                 
                  this.projectsOpt.newProject = '';
                  this.createNewProj = false;
            } else {
               this.errors = [];

               if (this.projectsOpt.newProject = '') {
                  this.errors.push('Il nome del progetto non può essere vuoto');
               }

               if (this.projectsOpt.newProject.length > 45) {
                  this.errors.push("Il nome del progetto non può essere più lungo di 45 caratteri")
               }
            }
         },

         editProject(id) {

            if(this.projectsOpt.editNameProj != '') {

               axios
                  .get('partials/ProjectController.php', {
                     params: {
                        name: this.projectsOpt.editNameProj,
                        id: id,
                     }
                  })
                  .then( response => {

                     if (response.status === 200) {
                        this.errors =[];
                        this.results = response.data.results;
                        this.categories = response.data.categories;
                     } else {
                        this.errors = response.data;
                     }

                  });

                  this.projectsOpt.editNameProj = '';
                  this.projectsOpt.editinput = false;
            } else {
               this.errors = [];

               if (this.projectsOpt.editProject = '') {
                  this.errors.push('Il nome del progetto non può essere vuoto');
               }

               if (this.projectsOpt.editProject.length > 45) {
                  this.errors.push("Il nome del progetto non può essere più lungo di 45 caratteri")
               }
            }
         },

         deleteProject(id) {

            axios
               .delete('partials/ProjectController.php', {
                  params: {
                     id: id,
                  }
               })
               .then( response => {
                  this.results = response.data.results;
                  this.categories = response.data.categories;
               } );
         },
         // Projects

         // Activities

         activityDone(id, actIndex, projIndex) {

            axios
               .get('partials/ActivityController.php', {
                  params: {
                     done: this.results[projIndex].activities[actIndex].done == '0' ? '1' : '0',
                     id: id
                  }
               })
               .then( response => {
                  this.results = response.data.results;
                  this.categories = response.data.categories;
               } )
         }, 

         createNewActivity(id) {
            if (this.activityOpt.newActivity.title != '' && this.activityOpt.newActivity.deadline != '' && this.activityOpt.newActivity.category_id != '-' && this.activityOpt.newActivity.maker != '' && this.activityOpt.newActivity.assigned_to != '') {

               let bodyFormData = new FormData();
               bodyFormData.append('title', this.activityOpt.newActivity.title);
               bodyFormData.append('project_id', id);
               bodyFormData.append('deadline', this.activityOpt.newActivity.deadline);
               bodyFormData.append('priority', this.activityOpt.newActivity.priority ? '1' : '0');
               bodyFormData.append('maker', this.userLogged);
               bodyFormData.append('assigned_to', this.activityOpt.newActivity.assigned_to);
               bodyFormData.append('text', this.activityOpt.newActivity.text);

               if (this.newCategory != "" && this.createCategory) {
                  
                  this.createNewCategory();
                  bodyFormData.append('category_id', "");

               } else {
                  bodyFormData.append('category_id', this.activityOpt.newActivity.category_id);
               }
   
               this.activityError = '';
   
               axios({
                  method: 'post',
                  url: './partials/ActivityController.php',
                  data: bodyFormData,
                  headers: { "Content-Type": "multipart/form-data" },
                  })
                  .then( response => {

                     if (response.status === 200) {
                        this.errors =[];
                        this.results = response.data.results;
                        this.categories = response.data.categories;
                     } else {
                        this.errors = response.data;
                     }

                  } );
   
                  this.activityOpt.newActivity.title = '';
                  this.activityOpt.newActivity.deadline = '';
                  this.activityOpt.newActivity.priority = false;
                  this.activityOpt.newActivity.assigned_to = '';
                  this.activityOpt.newActivity.text = '';
                  this.activityOpt.newActivity.category_id = "";
            } else {
               this.errors = [];
               
               if(this.activityOpt.newActivity.title == '') {
                  this.errors.push("Il nome dell'attività non può essere vuoto");
               }

               if (this.activityOpt.newActivity.title.length > 45) {
                  this.errors.push("Il nome dell'attività può avere massimo 45 caratteri");
               } else {
                  this.activityOpt.newActivity.title.length = '';
               }

               if (this.activityOpt.newActivity.category_id == "-") {
                  this.errors.push("Inserire una categoria esistente o crearne una nuova");
               }

               if (this.activityOpt.newActivity.deadline != dayjs(this.activityOpt.newActivity.deadline).format('YYYY-MM-DD')) {
                  this.errors.push("La data inserita non è valida");
               }

               if (dayjs().format('YYYY-MM-DD') > this.activityOpt.newActivity.deadline){
                  this.errors.push("Inserire una data successiva a quella corrente");
               } else {
                  this.activityOpt.newActivity.deadline = '';
               }
                  
               if (this.activityOpt.newActivity.assigned_to == '') {
                  this.errors.push("Assegnare il task a qualcuno");
               } else {
                  this.activityOpt.newActivity.assigned_to = '';
               }


            }
   
         },
   
         editActivity(id) {
            if (this.activityOpt.editActivity.title != '' && this.activityOpt.editActivity.deadline != '' && this.activityOpt.editActivity.maker != '' && this.activityOpt.editActivity.assigned_to != '') {
   
               axios
                  .get('partials/ActivityController.php', {
                     params: {
                        title: this.activityOpt.editActivity.title,
                        id: id,
                        deadline: this.activityOpt.editActivity.deadline,
                        priority: this.activityOpt.editActivity.priority ? '0' : '1',
                        maker: this.userLogged,
                        assigned_to: this.activityOpt.editActivity.assigned_to,
                        text: this.activityOpt.editActivity.text,
                        category_id: this.activityOpt.editActivity.category_id,
                     }
                  })
                  .then( response => {
                     if (response.status === 200) {
                        this.errors =[];
                        this.results = response.data.results;
                        this.categories = response.data.categories;
                     } else {
                        this.errors = response.data;
                     }
                  } );
            } else {

               this.errors = [];
               
               if(this.activityOpt.editActivity.title == '') {
                  this.errors.push("Il nome dell'attività non può essere vuoto");
               }

               if (this.activityOpt.editActivity.title.length > 45) {
                  this.errors.push("Il nome dell'attività può avere massimo 45 caratteri");
               } 

               if (this.activityOpt.editActivity.deadline != dayjs(this.activityOpt.editActivity.deadline).format('YYYY-MM-DD')) {
                  this.errors.push("La data inserita non è valida");
               }

               if (dayjs().format('YYYY-MM-DD') > this.activityOpt.editActivity.deadline){
                  this.errors.push("Inserire una data successiva a quella corrente");
               }
                  
               if (this.activityOpt.editActivity.assigned_to == '') {
                  this.errors.push("Assegnare il task a qualcuno");
               }
               
            }
         },

         massiveEditActivities() {
            if (this.activityOpt.editActivity.title != '' && this.activityOpt.editActivity.deadline != '' && this.activityOpt.editActivity.maker != '' && this.activityOpt.editActivity.assigned_to != '') {

               this.massiveActivities.forEach( id => {
                  axios
                     .get('partials/ActivityController.php', {
                        params: {
                           title: this.activityOpt.editActivity.title,
                           id: id,
                           deadline: this.activityOpt.editActivity.deadline,
                           priority: this.activityOpt.editActivity.priority ? '0' : '1',
                           maker: this.userLogged,
                           assigned_to: this.activityOpt.editActivity.assigned_to,
                           text: this.activityOpt.editActivity.text,
                           category_id: this.activityOpt.editActivity.category_id,
                        }
                     })
                     .then( response => {
                        if (response.status === 200) {
                           this.errors =[];
                           this.results = response.data.results;
                           this.categories = response.data.categories;
                        } else {
                           this.errors = response.data;
                        }
                     } );
               })

               this.massiveActivities = [];
               this.massiveFormOpen = false;

            } else {
               
               this.errors = [];
               
               if(this.activityOpt.editActivity.title == '') {
                  this.errors.push("Il nome dell'attività non può essere vuoto");
               }

               if (this.activityOpt.editActivity.title.length > 45) {
                  this.errors.push("Il nome dell'attività può avere massimo 45 caratteri");
               } 

               if (this.activityOpt.editActivity.deadline != dayjs(this.activityOpt.editActivity.deadline).format('YYYY-MM-DD')) {
                  this.errors.push("La data inserita non è valida");
               }

               if (dayjs().format('YYYY-MM-DD') > this.activityOpt.editActivity.deadline){
                  this.errors.push("Inserire una data successiva a quella corrente");
               }
                  
               if (this.activityOpt.editActivity.assigned_to == '') {
                  this.errors.push("Assegnare il task a qualcuno");
               }
            }
         },

         deleteActivity(id) {

            axios.delete('partials/ActivityController.php', {
               params: {
                  id: id
               }
            }).then( response => {
               this.results = response.data.results;
               this.categories = response.data.categories;
            } )
         },
         // Activities


         // SubActivities
         subActDone(id, subActIndex, actIndex, projIndex) {
   
            axios
               .get('partials/SubActivityController.php', {
                  params: {
                     done: this.results[projIndex].activities[actIndex].subActivities[subActIndex].done == '0' ? '1' : '0',
                     id: id
                  }
               })
               .then( response => {
                  console.log(response.data);
                  this.results = response.data.results;
                  this.categories = response.data.categories;
               } )
         },
   
         createNewSubActivity(id) {
   
            if(this.subActivityOpt.newSubActivity != '') {

               let bodyFormData = new FormData();
               bodyFormData.append('title', this.subActivityOpt.newSubActivity);
               bodyFormData.append('activity_id', id);

               axios({
                  method: 'post',
                  url: 'partials/SubActivityController.php',
                  data: bodyFormData,
                  headers: { "Content-Type": "multipart/form-data" },
                  })
                  .then( response => {
                     if (response.status === 200) {
                        this.errors =[];
                        this.results = response.data.results;
                        this.categories = response.data.categories;
                     } else {
                        this.errors = response.data;
                     }
                  } );
   
               this.subActivityOpt.newSubActivity = '';
            } else {

               this.errors = [];

               if (this.subActivityOpt.newSubActivity == '') {
                  this.errors.push('Il nome della sottoattività non può essere vuoto');
               } 

               if (this.subActvitiyOpt.newSubActivity.length > 45 ) {
                  this.errors.push('Il nome della sottoattività può avere massimo 45 caratteri');
               }
            }
         },
   
         deleteSubActivity(id) {
   
            axios
               .delete('partials/SubActivityController.php', {
                  params: {
                     id: id,
                  }
               })
               .then( response => {
                  this.results = response.data.results;
                  this.categories = response.data.categories;
               } )
         },
         // SubActivities

      // CRUD API


      openActivityEditForm(indexProj, indexAct) {

         this.results.forEach( project => {
            project.activities.forEach( activity => {
               activity.openEditForm = false;
            } )
         } );

         this.results[indexProj].activities[indexAct].openEditForm = true;

         this.activityOpt.editActivity.title = this.results[indexProj].activities[indexAct].title;
         this.activityOpt.editActivity.deadline = this.results[indexProj].activities[indexAct].deadline;
         this.activityOpt.editActivity.priority = this.results[indexProj].activities[indexAct].priority;
         this.activityOpt.editActivity.text = this.results[indexProj].activities[indexAct].text;
         this.activityOpt.editActivity.assigned_to = this.results[indexProj].activities[indexAct].assigned_to;
         this.activityOpt.editActivity.category_id = this.results[indexProj].activities[indexAct].category_id;

      },

      getSearchData() {

         if(this.searchInput != '') {
            axios
               .get(`partials/DatabaseController.php?inputSearch=${this.searchInput}`)
               .then( response => {
                  this.searchResults = response.data;
                  this.searchShow = true;
               } )
         }  else {
            this.searchResults = [];
         }
      },


      getData() {
         axios
            .get('partials/DatabaseController.php')
            .then( response => {
               this.results = response.data.results;
               this.categories = response.data.categories;
               this.showPage = true;
            } );
      },

      getUsers() {

         let bodyFormData = new FormData();
         bodyFormData.append('users', 1);

            axios({
               method: 'post',
               url: 'partials/DatabaseController.php',
               data: bodyFormData,
               headers: { "Content-Type": "multipart/form-data" },
             })
               .then( response => {
                  this.users = response.data;

                  this.users.forEach( item => {
                     item.logged == '1' ? this.userLogged = item.name : false;
                  } )
               } );
      },


      removeActivityByMassive(id) {

         this.massiveActivities.forEach( (item, index) => {
            if (item == id) {
               this.massiveActivities.splice(index, 1);
            }
         } )
      }

   },
   mounted() {
      this.getData();
      this.getUsers();
   }
});