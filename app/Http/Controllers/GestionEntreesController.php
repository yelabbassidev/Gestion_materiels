<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gestion_entrees;
use App\Models\Gestion_sorties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use intervention\Image\Facades\Image as Image;

class GestionEntreesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd("mm");
    }
    public function getEntrees($id){
       $gs_entrees= Gestion_entrees::where('article_id',$id)->orderby('date_entre','desc')->get();
       return $gs_entrees;
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
        $gs_entre = new Gestion_entrees;
        $gs_entre->typeBon = $request->e1_typebon;
        $gs_entre->id = $request->e2_id ;
        $gs_entre->article_id = $request->article_id ;
        $gs_entre->fournisseur = $request->e3_desi_four;
        $gs_entre->date_entre = $request->e4_date_en_so;
        $gs_entre->nbon = $request->e5_numerobon;
        $gs_entre->uploadBon = $request->e6_uploadbon;
        $gs_entre->quantite_entre = $request->e7_quantite;
        if($gs_entre->save()){
            $article = Article::find($request->article_id);
            $article->quantite_stock = $article->quantite_stock+$request->e7_quantite;
            $article->save();
        }
        return $gs_entre;
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
        return Gestion_entrees::find($id);
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
        $gs_entre = Gestion_entrees::find($id);
        $article = Article::find($gs_entre->article_id);
        $count_entrees = Article::find($gs_entre->article_id)->gestion_entrees()->sum('quantite_entre');
        $count_sorties = Article::find($gs_entre->article_id)->gestion_sorties()->sum('quantite_sortie');

        $result_count_entree = $count_entrees -$gs_entre->quantite_entre+$request->e7_quantite;

        if($result_count_entree>=$count_sorties){
            $article->quantite_stock = $article->quantite_stock- $gs_entre->quantite_entre + $request->e7_quantite;
            $article->save();
            $gs_entre->quantite_entre = $request->e7_quantite;
            $gs_entre->typeBon = $request->e1_typebon;
            $gs_entre->id = $request->e2_id ;
            $gs_entre->fournisseur = $request->e3_desi_four;
            $gs_entre->date_entre = $request->e4_date_en_so;
            $gs_entre->nbon = $request->e5_numerobon;
            $gs_entre->uploadBon = $request->e6_uploadbon;
            $gs_entre->save();
            return ['gs_entre'=>$gs_entre,'error'=>false];
        }else return ['gs_entre'=>$gs_entre,'error'=>true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gs_entre = Gestion_entrees::find($id);
        $article = Article::find($gs_entre->article_id);
        $count_entrees = Article::find($gs_entre->article_id)->gestion_entrees()->sum('quantite_entre');
        $count_sorties = Article::find($gs_entre->article_id)->gestion_sorties()->sum('quantite_sortie');

        if($count_sorties<=$count_entrees-$gs_entre->quantite_entre){
            $article = Article::find($gs_entre->article_id);
            $article->quantite_stock = $gs_entre->quantite_entre - $article->quantite_stock;
            $article->save();
            $gs= Gestion_entrees::destroy($id);
            return true;
        }
        return false;

    }
}
