@extends('frontend.layouts.app')

@section('content')

    <!-- SERVICE SECTION -->

    <section class="section grey lighten-4 center">
        <div class="container">
            <div class="row">
                <div class="col s12 m4">
                    <div class="card-panel">
                        <i class="material-icons large indigo-text">room</i>
                        <h5>Pick Where</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, alias.</p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card-panel">
                        <i class="material-icons large indigo-text">store</i>
                        <h5>Choose Place</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, alias.</p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card-panel">
                        <i class="material-icons large indigo-text">people</i>
                        <h5>Find Best Agent</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, alias.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FEATURED SECTION -->

    <section class="section">
        <div class="container">
            <div class="row">
                <h4 class="center">Featured Properties</h4>
            </div>
            <div class="row">

                @foreach($properties as $property)
                    <div class="col s12 m4">
                        <div class="card">
                            <div class="card-image">
                                @if(Storage::disk('public')->exists('property/'.$property->image) && $property->image)
                                    <span class="card-image-bg" style="background-image:url({{Storage::url('property/'.$property->image)}});"></span>
                                @else
                                    <span class="card-image-bg"><span>
                                @endif
                                @if($property->featured == 1)
                                    <a class="btn-floating halfway-fab waves-effect waves-light indigo" title="Featured"><i class="small material-icons">star</i></a>
                                @endif
                            </div>
                            <div class="card-content property-content">
                                <a href="{{ route('property.show',$property->slug) }}">
                                    <span class="card-title tooltipped" data-position="bottom" data-tooltip="{{ $property->title }}">{{ str_limit( $property->title, 18 ) }}</span>
                                </a>

                                <div class="address">
                                    <i class="small material-icons left">location_city</i>
                                    <span>{{ ucfirst($property->city) }}</span>
                                </div>
                                <div class="address">
                                    <i class="small material-icons left">place</i>
                                    <span>{{ ucfirst($property->address) }}</span>
                                </div>

                                <h5>
                                    ${{ $property->price }}
                                    <small class="right">{{ ucfirst($property->type) }} for {{ $property->purpose }}</small>
                                </h5>
                            </div>
                            <div class="card-action property-action">
                                <span class="btn-flat">
                                    <i class="material-icons">check_box</i>
                                    Bedroom: <strong>{{ $property->bedroom}}</strong> 
                                </span>
                                <span class="btn-flat">
                                    <i class="material-icons">check_box</i>
                                    Bathroom: <strong>{{ $property->bathroom}}</strong> 
                                </span>
                                <span class="btn-flat">
                                    <i class="material-icons">check_box</i>
                                    Area: <strong>{{ $property->area}}</strong> Square Feet
                                </span>
                                <span class="btn-flat">
                                    <i class="material-icons">comment</i> 
                                    <strong>{{ $property->comments_count}}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


    <!-- TESTIMONIALS SECTION -->

    <section class="section grey lighten-3 center">
        <div class="container">

            <h4>Testimonials</h4>

            <div class="carousel testimonials">

                @foreach($testimonials as $testimonial)
                    <div class="carousel-item testimonial-item" href="#{{$testimonial->id}}!">
                        <div class="card testimonial-card">
                            <span style="height:20px;display:block;"></span>
                            <div class="card-image testimonial-image">
                                <img src="{{Storage::url('testimonial/'.$testimonial->image)}}">
                            </div>
                            <div class="card-content">
                                <span class="card-title">{{$testimonial->name}}</span>
                                <p>
                                    {{$testimonial->testimonial}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </section>


    <!-- BLOG SECTION -->

    <section class="section center">
        <div class="row">
            <h4 class="center">Recent Blog</h4>
        </div>
        <div class="container">
            <div class="row">

                @foreach($posts as $post)
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                            @if(Storage::disk('public')->exists('posts/'.$post->image) && $post->image)
                                <span class="card-image-bg" style="background-image:url({{Storage::url('posts/'.$post->image)}});"></span>
                            @endif
                        </div>
                        <div class="card-content">
                            <span class="card-title tooltipped" data-position="bottom" data-tooltip="{{$post->title}}">
                                <a href="{{ route('blog.show',$post->slug) }}">{{ str_limit($post->title,18) }}</a>
                            </span>
                            {!! str_limit($post->body,120) !!}
                        </div>
                        <div class="card-action blog-action">
                            <a href="#" class="btn-flat">
                                <i class="material-icons">person</i>
                                <span>{{$post->user->name}}</span>
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
                                <i class="material-icons">watch_later</i>
                                <span>{{$post->created_at->diffForHumans()}}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection