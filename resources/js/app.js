/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var moment = require('moment'); // require

window.Vue = require('vue');
import Swal from 'sweetalert2'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('gestion-entrees', require('./components/gsEntrees.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var app = new Vue({
    el: '#app',

    data() {
        return{
            image: '',
            selectedFile : null,
            columns:[],
            entrees: [],
            sorties: [],
            articles: [],
            open:true,
            modifGestion:true,
            title:"",
            entre:true,
            article: {
                category:'',
                id:0,
                designation:'',
                code_stihl:'',
                materiel_adequat:'',
                quantite_stock:''
            },
            gestion: {
                e1_typebon:'',
                e2_id:0,
                article_id:0,
                e3_desi_four:'',
                e4_date_en_so:'',
                e5_numerobon:'',
                e6_uploadbon:'',
                e7_quantite:''
            },

        }
     },
     methods: {
         dateAsHumans:function(stringDate){
            return moment(stringDate);
         },
         ajouterGestion(){
            app.open=true
            app.gestion.e1_typebon=""
            app.gestion.e2_id=0
            app.gestion.e3_desi_four=""
            app.gestion.e4_date_en_so=""
            app.gestion.e5_numerobon=""
            app.gestion.e6_uploadbon=""
            app.gestion.e7_quantite=""
         },
         storeGestion(gestion){
           // console.log(gestion)
            if(app.entre==false){
                axios.post('gestionsorties/',gestion).then(function(response){
                   // console.log(response.data)
                   if(response.data.error){
                       Swal.fire(
                           'ERROR MODIFICATION!',
                           'TOTAL LES SORTIES PLUS QUE LES ENTREES',
                           'error'
                           )
                        }else{
                        app.getSorties(response.data.gs_sortie.article_id);
                        app.getArticles();
                        app.uploadImage(response.data.gs_sortie.id,"sortie")
                      }
                });
            }else{
                axios.post('gestionentrees/',gestion).then(function(response){
                    // console.log(response.data)
                    app.getEntrees(response.data.article_id);
                    app.getArticles();
                    app.uploadImage(response.data.id,"entre");

                 });
            }
         },
        getEntrees: function(id){
            app.gestion.article_id = id;

            axios.get('/getEntrees/'+id)
            .then(function (response) {
                app.entre=true;
                app.columns=['FOURNISSEUR','QUANTITE ENTRE','DATE ENTRE','NUMEROBON','TYPE BON','IMAGE BON','DATE MODIFICATION','OPTIONS'];
                app.title = 'ENTREES';
                app.sorties = [];
                app.entrees = response.data;
            })
            .catch(function (error) {

                console.log(error);
            });
        },
        getSorties: function(id){
            app.gestion.article_id = id;

            axios.get('/getSorties/'+id)
            .then(function (response) {
                app.entre=false;
                app.columns=['DESIGNATION','QUANTITE SORTIE','DATE SORTIE','NUMEROBON','TYPE BON','IMAGE BON','DATE MODIFICATION','OPTIONS'];
                app.title = 'SORTIES';
                app.entrees =[];

                app.sorties = response.data;
              //  console.log( app.sorties);
                //console.log( app.entrees);
            })
            .catch(function (error) {

                console.log(error);
            });
        },
         getArticles: function(){
            axios.get('/getArticles')
                .then(function (response) {
                    app.articles = response.data;

                    //console.log( app.articles);
                })
                .catch(function (error) {

                    console.log(error);
                });
         },
         editArticle: function(id){
            axios.get('article/'+id+'/edit')
                .then(function (response) {
                    app.article = response.data;
                    //someArray = app.articles.filter(person => person.id != app.article.id);
                    //console.log(app.articles );
                })
                .catch(function (error) {

                    console.log(error);
                });
         },
         updateArticle: function(article){
            axios.put('article/'+article.id,article).then(function (response) {
              //  console.log(article);
              app.getArticles();
                //console.log(response.data );
            })
            .catch(function (error) {

                console.log(error);
            });

         },
         deleteArticle: function(article){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('article/'+article.id).then(function (response) {
                        //  console.log(article);
                        app.getArticles();
                      })
                      .catch(function (error) {

                          console.log(error);
                      });
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                }else{
                    return "<script>alert('ERROR')</script>";
                }
              })


         },
         editGestion: function(sortie){
            axios.get('gestionsorties/'+sortie.id+'/edit').then(function(response){
                app.modifGestion=true;
                app.open=false;

               app.gestion.e1_typebon = response.data.typeBon;
               app.gestion.e2_id = response.data.id ;
               app.gestion.e3_desi_four = response.data.designation;
               app.gestion.e4_date_en_so = response.data.date_sortie;
               app.gestion.e5_numerobon = response.data.nbonfact;
               app.gestion.e6_uploadbon = response.data.uploadBon;
               app.gestion.e7_quantite = response.data.quantite_sortie;
            });
        },
        updateGestion: function(gestion){
            if(app.modifGestion==true){
                axios.put('gestionsorties/'+gestion.e2_id,gestion).then(function(response){
                    console.log(response.data)
                    app.getSorties(response.data.gs_sortie.article_id);
                    app.getArticles();
                    app.uploadImage(response.data.gs_sortie.id,"sortie")
                    if(response.data.error){
                        Swal.fire(
                            'ERROR MODIFICATION!',
                            'LES SORTIES PLUS QUE LES ENTREES',
                            'error'
                          )
                      }
                });
            }else{
                axios.put('gestionentrees/'+gestion.e2_id,gestion).then(function(response){
                    console.log(response.data.gs_entre)
                  app.getEntrees(response.data.gs_entre.article_id);
                  app.getArticles();
                  app.uploadImage(response.data.gs_entre.id,"entre")
                  if(response.data.error){
                    Swal.fire(
                        'ERROR MODIFICATION!',
                        'LES SORTIES PLUS QUE LES ENTREES',
                        'error'
                      )
                  }
                });
            }
            app.open=true

        },
        deleteGestion: function(gestion){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('gestionsorties/'+gestion.id).then(function(response){
                        app.getSorties(gestion.article_id);
                        app.getArticles();
                      //  console.log("Deleted :" + response.data);

                     });
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                }
              })

        },
        editEntree: function(entree){
           axios.get('gestionentrees/'+entree.id+'/edit').then(function(response){
                app.modifGestion=false;
                app.open=false;

              app.gestion.e1_typebon = response.data.typeBon;
              app.gestion.e2_id = response.data.id ;
              app.gestion.e3_desi_four = response.data.fournisseur;
              app.gestion.e4_date_en_so = response.data.date_entre;
              app.gestion.e5_numerobon = response.data.nbon;
              app.gestion.e6_uploadbon = response.data.uploadBon;
              app.gestion.e7_quantite = response.data.quantite_entre;
           });
       },

       deleteEntree: function(entree){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('gestionentrees/'+entree.id).then(function(response){
                    app.getEntrees(entree.article_id);
                    app.getArticles();
                   // console.log(response.data);
                    if(!response.data){
                        Swal.fire(
                            'SUPPRISSION LES ENTREES',
                            'LES SORTIES PLUS QUE LES ENTREES',
                            'error'
                          )
                    }else{
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )
                    }

                 });

            }
          })

       },


        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        uploadImage(id_g,type_g){
            axios.post('/api/upload',{image: this.image,id:id_g,type:type_g}).then(response => {
               if (response.data.success) {
                 alert(response.data.success);
               }
            if(response.data.type =="entre")   app.getEntrees(response.data.article_id);
            if(response.data.type =="sortie")   app.getSorties(response.data.article_id);
            });
        }



     },
     mounted() {
         this.getArticles();
     }
});

