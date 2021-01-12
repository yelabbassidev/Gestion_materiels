<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gestion_entrees;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:article-list|article-create|article-edit|article-delete', ['only' => ['index','show']]);
         $this->middleware('permission:article-create', ['only' => ['create','store']]);
         $this->middleware('permission:article-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:article-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$articles = Article::with('gestion_entrees')->whereId('513')->get();
        //$articles = Article::find('513')->gestion_entrees;
        //dd($articles);

       /* $articles = Article::orderBy('category', 'desc')
        ->get();*/
        return view('index');
    }
    public function getArticles()
    {
        $articles = Article::orderBy('category', 'ASC')
        ->get();
        return json_encode($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article =new Article;
        $article->designation = $request->designation;
        $article->code_stihl = $request->codestihl;
        $article->materiel_adequat = $request->materieladequat;
        $article->category = $request->category;
        $article->quantite_stock = $request->quantitestock;

        if($article->save()){
            $request->session()->flash('statut','Votre article à été Bien D\'ajouter ');
        }else{
            $request->session()->flash('error','Votre article n\'est pas enregistrer ');
        }


        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article = Article::find($article->id);
        $article->designation = $request->designation;
        $article->category = $request->category;
        $article->code_stihl = $request->code_stihl;
        $article->quantite_stock = $request->quantite_stock;
        $article->materiel_adequat = $request->materiel_adequat;
        $article->save();

        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article = Article::destroy($article->id);

    }
}
