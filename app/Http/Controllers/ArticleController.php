<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;

class ArticleController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new middleware('permission:view articles', only:['index']),
            new middleware('permission:edit articles', only:['edit']),
            new middleware('permission:create articles', only:['create']),
            new middleware('permission:delete articles', only:['destroy']),
        ];
    }
    public function index()
    {
        //
        $articles = Article::latest()->paginate(5);
        return view('articles.show',['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('articles.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'title' => 'required|min:3',
            'author' => 'required|min:3'
        ]
        );
        if($validator->passes()){
            Article::create([
                'title' => $request->title,
                'content'=> $request->content,
                'author'=>$request->author
            ]);
            return redirect()->route('articles.show')->with('success','Article Created Successfully');
        }
        else{
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }
    // function for edit permission page
    public function edit($id){
        $article = Article::findOrFail($id);
        return view('articles.edit',['article' => $article]);
        
    }
    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'title' => 'required|min:3',
            'author' => 'required|min:3'
        ]);
        if($validator->passes()){
            $article = Article::findOrFail($id);
            $article->title = $request->title;
            $article->content = $request->content;
            $article->author = $request->author;
            $article->save();
            return redirect()->route('articles.show')->with('success','Article Updated Successfully');
        }
        else{
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $article = Article::find($request->id);
        if($article == null){
            session()->flash('error','Article not found in DB');
            return response()->json([
                'status'=> false
            ]);
        }
            $article->delete();
            session()->flash('success','Article Deleted Successfully');
            return response()->json([
                'status'=> true,
            ]);
    }
}
