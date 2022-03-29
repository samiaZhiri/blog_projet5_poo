<?php

namespace App\controllers;

use Controller;
use App\Models\Post;
use App\Models\Comment;
use App\https\HttpRequest;


class HomeController extends Controller
{

    public function index()
    {
        //requête qui retrouve mes articles
        $queries = Post::orderBy('created_at', 'desc')->get();
        // var_dump($queries);
        return $this->view('home/index', compact('queries'));
    }
    public function show($id)
    {
        //requête qui retrouve mon article correspondant à l'id
        $post = Post::find($id);
        $comments = Comment::where('post_id', $id)->get();
        return $this->view('home/show', compact('post', 'comments'));
    }
    public function create(HttpRequest $request)
    {
    }
    public function cmtcreate(HttpRequest $request)
    {
        //je veux récupérer l'id car je veux faire un commentaire
        //sur un post, pour cela ds le form j'ai crée un champs input hidden
        //et ds value j'ai mis post.id
        $id = $request->name('post_id');

        //je veux récupérer les autres champs
        $feilds = $request->all(); //ca va récupéré un tableau avec 
        //toutes les valeurs passées ds le form
        Comment::create($feilds);
        //je redirige le user sur la meme page
        return redirect('home/show', ['id' => $id]);
    }
}
