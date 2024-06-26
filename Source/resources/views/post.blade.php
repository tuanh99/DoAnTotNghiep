@extends('main')
@section('content')

<section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div id="loadPost">
            @include('posts.list')
            </div>

        </div>
    </section>
@endsection