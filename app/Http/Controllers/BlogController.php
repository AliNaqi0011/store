<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function listing(){
        $blogs = Blogs::all();
        return view('admin.blogs.listing',compact('blogs'));
    }

    public function create(){
        return view('admin.blogs.create');
    }

    public function store(Request $request){

        // Create a new Blog instance and fill it with validated data
        $blog = new Blogs();
        $blog->title = $request->title;
        $blog->meta_title = $request->title;
        $blog->slug = $request->slug;
        $blog->tags = $request->tags;
        $blog->meta_description = $request->description;

        // Save the blog post
        $blog->save();

        return redirect()->route('blog.listing')->with(['success' => 'Blog Added successfully!']);
    }

    public function edit($id){
        $blogs = Blogs::where('id',$id)->first();
        return view('admin.blogs.edit', compact('blogs'));
    }

    public function update(Request $request)
    {

        $blog = Blogs::find($request->id);

        if ($blog) {
            $blog->title = $request->title;
            $blog->meta_title = $request->title;
            $blog->slug = $request->slug;
            $blog->tags = $request->tags;
            $blog->meta_description = $request->description;

            $blog->save();

        }
        return redirect()->route('blog.listing')->with('success', 'Blog Updated successfully.!');
    }

    public function delete($id){
        Blogs::where('id',$id)->delete();
        return redirect()->route('blog.listing')->with('error', 'Blog delete successfully.!');
    }
}
