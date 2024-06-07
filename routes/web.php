<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/blog')->name('blog.')->group(function () {
    Route::get('/', function (Request $request) {

        /*$poste = new \App\Models\Post();
        $poste->title = 'Mon second Article';
        $poste->slug = 'mon-second-article';
        $poste->content = "Mon Contenue";
        $poste->save();
        $return $post
        */
        //Retourner les élèments de la base de donnée sur le navigateur
        //$posts = \App\Models\Post::paginate(1, ["id", "title"]);
        //dd($posts);

        return \App\Models\Post::paginate(25);

        return [
            "link" => \route('blog.index', ['slug' => 'article', 'id' => 15])
        ];
    })->name('index');

    Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request) {
        $post = \App\Models\Post::findDrFail($id);

        if ($post->slug =! $slug) {
            return to_route('blog.show', ['slug' => $post->slug, 'id' => $post->id]);
        }
        return $post;
        
        return [
            "slug" => $slug,
            "id" => $id,
            'name' => $request->input('name')
        ];
    })->where([
        'id' => '[0-9]+',
        'slug' => '[a-z0-9\-]+'
    ])->name('show');
});
