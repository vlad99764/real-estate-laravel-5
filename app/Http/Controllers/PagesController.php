<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Property;
use App\Message;
use App\Gallery;
use App\Comment;
use App\Rating;
use App\Post;
use App\User;
use Auth;
use DB;

class PagesController extends Controller
{
    public function properties()
    {
        $properties = Property::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.properties.property', compact('properties'));
    }

    public function propertieshow($slug)
    {
        $property = Property::with('features','gallery','user')
                            ->withCount('comments')
                            ->where('slug', $slug)
                            ->first();
        
        $rating = Rating::where('property_id',$property->id)->where('type','property')->avg('rating');                   

        $comments = Comment::with('users','children')
                           ->where('commentable_id',$property->id)
                           ->get();

        $relatedprop = Property::latest()
                    ->where('purpose', $property->purpose)
                    ->where('type', $property->type)
                    ->where('bedroom', $property->bedroom)
                    ->where('bathroom', $property->bathroom)
                    ->where('id', '!=' , $property->id)
                    ->take(5)->get();

        return view('pages.properties.single', compact('property','comments','rating','relatedprop'));
    }


    // AGENT PAGE
    public function agents()
    {
        $agents = User::latest()->where('role_id', 2)->paginate(12);

        return view('pages.agents.index', compact('agents'));
    }

    public function agentshow($id)
    {
        $agent      = User::findOrFail($id);
        $properties = Property::latest()->where('agent_id', $id)->paginate(10);

        return view('pages.agents.single', compact('agent','properties'));
    }


    // BLOG PAGE
    public function blog()
    {
        $posts = Post::latest()->withCount('comments')->where('status',1)->paginate(10);

        return view('pages.blog.index', compact('posts'));
    }

    public function blogshow($slug)
    {
        $post = Post::with('comments')->withCount('comments')->where('slug', $slug)->first(); 

        $comments = Comment::with('users','children')
                           ->where('commentable_id',$post->id)
                           ->get();

        return view('pages.blog.single', compact('post','comments'));
    }


    // MESSAGE TO AGENT (SINGLE AGENT PAGE)
    public function messageAgent(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        if($request->ajax()){
            return response()->json(['message' => 'Message send successfully.']);
        }

    }

    
    // CONATCT PAGE
    public function contact()
    {
        return view('pages.contact');
    }

    public function messageContact(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        if($request->ajax()){
            return response()->json(['message' => 'Message send successfully.']);
        }

    }


    // GALLERY PAGE
    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('pages.gallery',compact('galleries'));
    }


    // PROPERTY COMMENT
    public function propertyComments(Request $request, $id)
    {
        $request->validate([
            'body'  => 'required',
        ]);

        $property = Property::find($id);

        $property->comments()->create(
            [
                'user_id'   => Auth::id(),
                'body'      => $request->body,
                'parent'    => $request->parent,
                'parent_id' => $request->parent_id,
            ]
        );

        return back();
    }

    // BLOG COMMENT
    public function blogComments(Request $request, $id)
    {
        $request->validate([
            'body'  => 'required',
        ]);

        $post = Post::find($id);

        $post->comments()->create(
            [
                'user_id'   => Auth::id(),
                'body'      => $request->body,
                'parent'    => $request->parent,
                'parent_id' => $request->parent_id,
            ]
        );

        return back();
    }

    // PROPERTY RATING
    public function propertyRating(Request $request)
    {
        $rating      = $request->input('rating');
        $property_id = $request->input('property_id');
        $user_id     = $request->input('user_id');
        $type        = 'property';

        $rating = Rating::updateOrCreate(
            ['user_id' => $user_id, 'property_id' => $property_id, 'type' => $type],
            ['rating' => $rating]
        );

        if($request->ajax()){
            return response()->json(['rating' => $rating]);
        }
    }
    
}
