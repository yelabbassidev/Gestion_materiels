<?php

use App\Models\Gestion_entrees;
use App\Models\Gestion_sorties;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/upload', function (Request $request) {


    if($request->get('image'))
       {
          $image = $request->get('image');
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          Image::make($request->get('image'))->save(public_path('images/').$name);



        if($request->get('type') == "entre"){
            $image= Gestion_entrees::find($request->get('id'));
            }else if($request->get('type') == "sortie"){
                $image= Gestion_sorties::find($request->get('id'));
            }
       $image->uploadBon = "images/".$name;
       $image->save();

       return response()->json(['success' => 'You have successfully uploaded an image',
                                'article_id' => $image->article_id,
                                'type' => $request->get('type')], 200);
}
});
