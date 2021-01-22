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
