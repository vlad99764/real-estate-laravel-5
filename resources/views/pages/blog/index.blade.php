@extends('frontend.layouts.app')

@section('styles')

@endsection

@section('content')

    <section class="section">
        <div class="container">
            <div class="row">

                <div class="col s12 m8">

                    @foreach($posts as $post)
                        <div class="card horizontal">
                            <div>
                                <div class="card-content">
                                    @if(Storage::disk('public')->exists('posts/'.$post->image) && $post->image)
                                        <div class="card-image blog-content-image">
                                            <img src="{{Storage::url('posts/'.$post->image)}}" alt="{{$post->title}}">
                                        </div>
                                    @endif
                                    <span class="card-title" title="{{$post->title}}">
                                        <a href="{{ route('blog.show',$post->slug) }}">{{ $post->title }}</a>
                                    </span>
                                    {!! str_limit($post->body,120) !!}
                                </div>
                                <div class="card-action blog-action clearfix">
                                    <a href="#" class="btn-flat">
                                        <i class="material-icons">person</i>
                                        <span>{{$post->user->name}}</span>
                                    </a>
                                    <a href="#" class="btn-flat">
                                        <i class="material-icons">watch_later</i>
                                        <span>{{$post->created_at->diffForHumans()}}</span>
                                    </a>
                                    @foreach($post->categories as $key => $category)
                                        <a href="#" class="btn-flat">
                                            <i class="material-icons">folder</i>
                                            <span>{{$category->name}}</span>
                                        </a>
                                    @endforeach
                                    @foreach($post->tags as $key => $tag)
                                        <a href="#" class="btn-flat">
                                            <i class="material-icons">label</i>
                                            <span>{{$tag->name}}</span>
                                        </a>
                                    @endforeach
                                    
                                    <a href="#" class="btn-flat">
                                        <i class="material-icons">comment</i>
                                        <span>{{$post->comments_count}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="m-t-30 m-b-60 center">
                        {{ $posts->links() }}
                    </div>
        
                </div>

                <div class="col s12 m4">

                    <div class="card">
                        <div class="card-content">
                            <h3 class="card-title m-t-0">Slidebar</h3>        
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, quis!</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection