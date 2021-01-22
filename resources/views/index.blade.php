@extends('layouts.app')



@section('content')

<div class="container-fluid" id="app">
    <center><h1 class="align-center mb-5 mt-2">REEL STOCK </h1></center>

    @if (Session::Has('statut'))
        <div class="alert alert-success" role="alert"> {{Session('statut')}} </div>
    @endif
    @if (Session::Has('error'))
        <div class="alert alert-danger" role="alert"> {{Session('error')}} </div>
    @endif


 <!-- Button trigger modal -->
 @can('user-create')

  <x-test-button btn_x="+"></x-test-button>

  @endcan

  <!-- Modal -->
  <form action="{{route('article.store')}}" name="modalAjouter" method="POST">
    @csrf
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Ajouter Article</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <label for="CATEGORIE">CATEGORIE</label>
                    <select class="form-control" name="category">
                    <option value="STIHL">STIHL</option>
                    <option value="KUBOTA">ISIKI && KUBOTA</option>
                    </select>
                  </div>
                <div class="form-group">
                  <label for="designation">DESIGNATION</label>
                  <input type="text" class="form-control" name="designation" id="designation" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="CODESTIHL">CODE STIHL</label>
                    <input type="text" class="form-control" name="codestihl" id="codestihl">
                  </div>
                  <div class="form-group">
                    <label for="MATERIELADEQUAT">MATERIEL ADEQUAT</label>
                    <input type="text" class="form-control" name="materieladequat" id="MATERIELADEQUAT">
                  </div>
                  <div class="form-group">
                    <label for="quantitestock">QUANTITE STOCK</label>
                    <input type="number" class="form-control" name="quantitestock" id="QUANTITESTOCK" min="0">
                  </div>
                </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
            <button type="submit" class="btn btn-primary">ENREGISTRER</button>
        </div>
    </div>
</div>
</div>
</form>

    <table class="table ">
        <thead>
          <tr>
            <th scope="col">CATEGORIE</th>
            <th scope="col">DESIGNATION</th>
            <th scope="col">CODE STIHL</th>
            <th scope="col">MATERIEL ADEQUAT</th>
            <th scope="col">QUANTITE</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
            <tr class="" v-for="article in articles">
                <th scope="row">@{{article.category}}</th>
                <td>@{{article.designation}}</td>
                <td>@{{article.code_stihl}}</td>
                <td>@{{article.materiel_adequat}}</td>
                <td>@{{article.quantite_stock}}</td>
                <td>
                    <div>
                        <button type="button" class="btn btn-dark"  data-toggle="modal" data-target="#exampleModalLong" @click="getEntrees(article.id)">
                        AFFICHER ENTREES
                      </button>
                    <button class="btn btn-info"  data-toggle="modal" data-target="#exampleModalLong" @click="getSorties(article.id)">AFFICHER SORTIES</button>

                    @can('user-edit')
                    <button type="button" class="btn btn-warning "
                         data-toggle="modal" data-target="#staticBackdrop2"
                         @click="editArticle(article.id)">
                        MODIFIER
                      </button>
                      @endcan
                      @can('article-delete')
                        <button class="btn btn-danger" @click="deleteArticle(article)">SUPPRIMER</button>
                    @endcan
                    </div>
                </td>
            </tr>
        </tbody>
      </table>


<!-- Modal Entrees&&Sorties -->
<div class="modal fade bd-example-modal-xl" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">GESTION @{{title}} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <button type="button" class="btn btn-success float-right mb-3" data-toggle="modal"
                    data-target="#modifierEntreeSortie" @click="ajouterGestion()"
                    >+</button>

            <table class="table table-hover">
                <thead class="thead-dark">
                  <tr >
                    <th v-for="column in columns" scope="col">@{{column}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if='entre==true' v-for="item in entrees">
                    <th scope="row">@{{item.fournisseur}}</th>
                    <td>@{{item.quantite_entre}}</td>
                    <td>@{{item.date_entre}}</td>
                    <td>@{{item.nbon}}</td>
                    <td v-if="item.typeBon=='BonLivraison'">BON LIVRAISON</td>
                    <td v-else="item.typeBon=='Fact'">FACTURE</td>
                    <td width='250px'>
                        <a data-fancybox="gallery" :href="item.uploadBon"><img width="20%" :src="item.uploadBon"></a>

                    </td>
                    <td>@{{dateAsHumans(item.updated_at).fromNow()}}</td>
                    <td><button class="btn btn-warning" data-toggle="modal" data-target="#modifierEntreeSortie" @click="editEntree(item)">MODIFIER</button>
                        <button class="btn btn-danger" @click="deleteEntree(item)">SUPPRIMER</button></td>
                  </tr>
                  <tr  v-for="sortie in sorties" >
                    <th scope="row">@{{sortie.designation}}</th>
                    <td>@{{sortie.quantite_sortie}}</td>
                    <td>@{{sortie.date_sortie}}</td>
                    <td>@{{sortie.nbonfact}}</td>
                    <td>BON SORTIE</td>
                    <td width='250px'>
                        <a data-fancybox="gallery" :href="sortie.uploadBon"><img width="20%" :src="sortie.uploadBon"></a>

                    </td>
                    <td>@{{dateAsHumans(sortie.updated_at).fromNow()}}</td>
                    <td><button class="btn btn-warning" data-toggle="modal" data-target="#modifierEntreeSortie" @click="editGestion(sortie)">MODIFIER</button>
                        <button class="btn btn-danger" @click="deleteGestion(sortie)">SUPPRIMER</button></td>
                  </tr>

                </tbody>
              </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<!-- Modal MODIFIER ENTREE&&SORTIES -->
<div class="modal fade" id="modifierEntreeSortie" tabindex="-1" role="dialog" aria-labelledby="modifierEntreeSortieTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modifierEntreeSortieTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="typeBon">TYPE BON</label>
                <select class="form-control" name="typeBon" id="typeBon" v-model="gestion.e1_typebon">
                <option value="Fact" v-if='entre==true' >FACTURE</option>
                <option value="BonLivraison" v-if='entre==true'>BON LIVRAISON</option>
                <option value="BonSortie"  v-if='entre==false'>BON SORTIE</option>
                </select>
              </div>
            <div class="form-group">
                <input type="hidden" name="id" id="id" v-model="gestion.e2_id">
              <label for="designation">DESIGNATION</label>
              <input type="text" class="form-control" name="designation" id="designation" v-model="gestion.e3_desi_four" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="date">DATE</label>
                <input type="date" class="form-control" name="date" id="date" v-model="gestion.e4_date_en_so">
              </div>
              <div class="form-group">
                <label for="nbon">NUMERO BON</label>
                <input type="number" class="form-control" name="nbon" id="nbon" v-model="gestion.e5_numerobon" min="0">
              </div>
              <div class="form-group">
                <label for="quantite_stock">QUANTITE STOCK</label>
                <input type="number" class="form-control" name="quantite_stock" id="quantite_stock"  v-model="gestion.e7_quantite" min="0">
              </div>
              <div class="form-group">
                <label for="gestion.e6_uploadbon">IMAGE BON</label>
                <input type="file" v-on:change="onImageChange" class="form-control">
                <center class="mt-2"><a data-fancybox="gallery" :href="gestion.e6_uploadbon">
                    <img width="20%" :src="gestion.e6_uploadbon"></a>
                </center>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" v-if="open==true" @click="storeGestion(gestion)" >AJOUTER</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" v-else @click="updateGestion(gestion)" >ENREGISTRER</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal MODIFIER article-->
<form action="?" name="modalUpdate" >
    @method('put')
    @csrf
  <div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Update Article</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <label for="category">CATEGORIE</label>
                    <select class="form-control" name="category" id="category" v-model="article.category">
                    <option value="STIHL">STIHL</option>
                    <option value="KUBOTA">ISIKI && KUBOTA</option>
                    </select>
                  </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id" v-model="article.id">
                  <label for="designation">DESIGNATION</label>
                  <input type="text" class="form-control" name="designation" id="designation" v-model="article.designation" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="code_stihl">CODE STIHL</label>
                    <input type="text" class="form-control" name="code_stihl" id="code_stihl" v-model="article.code_stihl">
                  </div>
                  <div class="form-group">
                    <label for="materiel_adequat">MATERIEL ADEQUAT</label>
                    <input type="text" class="form-control" name="materiel_adequat" id="materiel_adequat" v-model="article.materiel_adequat">
                  </div>
                  <div class="form-group">
                    <label for="quantite_stock">QUANTITE STOCK</label>
                    <input type="number" class="form-control" name="quantite_stock" id="quantite_stock"  v-model="article.quantite_stock" min="0">
                  </div>
                </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="updateArticle(article)">MODIFIER</button>
        </div>
    </div>
</div>
</div>
</form>

  </div>
@endsection
