<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     * アクセスコントローラー（expect=>引数にいれたアクションメソッドはログインしなくても閲覧可能）
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        //$posts = DB::select('SELECT * from posts');
        //$posts = Post::orderby('title','desc')->get();
        //$posts = Post::orderby('title','desc')->take(1)->get();
        $posts = Post::orderby('created_at','desc')->paginate(3);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            // required = be must post.
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')) {
            $fileNameWithExt = $request -> file('cover_image')->getClientOriginalName();
            $fileName = PATHINFO($fileNameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);

        } else {

            $fileNameToStore = "noimage.png";
        }

        $post = new Post;
        $post ->title = $request -> input('title');
        $post ->body = $request -> input('body');
        // DBにuserIDを追加
        $post ->user_id = auth()-> user()->id;
        $post->cover_image = $fileNameToStore;
        $post -> save();

        return redirect('/posts')->with('success','Post created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        // urlに/posts/post number を入力した時にeditにアクセスできてしまうため、アクセス制御する処理
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error','Unauthorized page');
        }
        return view('posts.edit')->with('post',$post);
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
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')) {
            $fileNameWithExt = $request -> file('cover_image')->getClientOriginalName();
            $fileName = PATHINFO($fileNameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);

        }

        $post = Post::find($id);
        $post -> title = $request -> input('title');
        $post -> body = $request -> input('body');
        $post->cover_image = $fileNameToStore;
        $post -> save();

        return redirect('/posts')->with('success','Post updated');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->cover_image !== 'noimage.png') {
            //Serverの画像を削除
            Storage::delete('public/cover_image/'.$post->cover_image);
        }
        //DBからpostデータを削除
        $post->delete();
        return redirect('/posts')->with('success','Post Deleted');

    }

    public function search(Request $request)
    {
        // タイトルに基づいて検索する
        //get('search') ←input name
        $search = $request->get('search');
        $posts = DB::table('posts')->where('title','like','%'.$search.'%')->paginate(5);
        return view('dashboard',['posts' => $posts]);
    }
}
