<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gestion_sorties;
use Illuminate\Http\Request;

class GestionSortiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getSorties($id){
        $gs_sorties= Gestion_sorties::where('article_id',$id)->orderby('date_sortie','desc')->get();
        return( $gs_sorties);
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
       // dd($request);
        $gs_sortie =new Gestion_sorties;

        $article = Article::find($request->article_id);
        $count_entrees = Article::find($request->article_id)->gestion_entrees()->sum('quantite_entre');
        $count_sorties = Article::find($request->article_id)->gestion_sorties()->sum('quantite_sortie');

        $result_count_sortie = $count_sorties + $request->e7_quantite;

        if($count_entrees>=$result_count_sortie){
            $gs_sortie->typeBon = $request->e1_typebon;
            $gs_sortie->article_id = $request->article_id;
            $gs_sortie->id = $request->e2_id ;
            $gs_sortie->designation = $request->e3_desi_four;
            $gs_sortie->date_sortie = $request->e4_date_en_so;
            $gs_sortie->nbonfact = $request->e5_numerobon;
            $gs_sortie->uploadBon = $request->e6_uploadbon;
            $gs_sortie->quantite_sortie = $request->e7_quantite;
            $gs_sortie->save();
            if($gs_sortie->save()){
                $article = Article::find($request->article_id);
                $article->quantite_stock = $article->quantite_stock-$request->e7_quantite;
                $article->save();
            }
            return ['gs_sortie'=>$gs_sortie,'error'=>false];
        }else return ['error'=>true];


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Gestion_sorties::find($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gs_sortie = Gestion_sorties::find($id);
        $article = Article::find($gs_sortie->article_id);
        $count_entrees = Article::find($gs_sortie->article_id)->gestion_entrees()->sum('quantite_entre');
        $count_sorties = Article::find($gs_sortie->article_id)->gestion_sorties()->sum('quantite_sortie');

        $result_count_sortie = $count_sorties -$gs_sortie->quantite_sortie+$request->e7_quantite;

        if($count_entrees>=$result_count_sortie){
            $article->quantite_stock = $article->quantite_stock+ $gs_sortie->quantite_sortie - $request->e7_quantite;
            $article->save();
            $gs_sortie->quantite_sortie = $request->e7_quantite;
            $gs_sortie->typeBon = $request->e1_typebon;
            $gs_sortie->id = $request->e2_id ;
            $gs_sortie->designation = $request->e3_desi_four;
            $gs_sortie->date_sortie = $request->e4_date_en_so;
            $gs_sortie->nbonfact = $request->e5_numerobon;
            $gs_sortie->uploadBon = $request->e6_uploadbon;
            $gs_sortie->quantite_sortie = $request->e7_quantite;
            $gs_sortie->save();
            return ['gs_sortie'=>$gs_sortie,'error'=>false];
        }else return ['gs_sortie'=>$gs_sortie,'error'=>true];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gs_sortie = Gestion_sorties::find($id);
        $article = Article::find($gs_sortie->article_id);
        $article->quantite_stock = $gs_sortie->quantite_sortie + $article->quantite_stock;
        $article->save();
        $gs= Gestion_sorties::destroy($id);
        return true;
    }
}
