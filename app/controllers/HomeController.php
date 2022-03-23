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
}
