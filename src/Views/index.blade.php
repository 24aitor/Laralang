@extends('laralang::template')
@section('title', 'Home - Laralang')
@section('page_title', 'Laralang')
@section('content')
<div class="container" style="padding-bottom:100px;margin-top:100px;">
    @php
        $actions = [
            'View DB translations' => Aitor24\Linker\Facades\Linker::route('laralang::translations'),
            'Filter DB translations' => Aitor24\Linker\Facades\Linker::route('laralang::filter'),
            'Translate php files' => Aitor24\Linker\Facades\Linker::route('laralang::translate'),
        ];
    @endphp
    @foreach ($actions as $name => $link)
        <div class="row">
            <div class="col-sm-10 col-lg-6 offset-sm-1 offset-lg-3">
                <a href="{{$link}}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-block" style="margin-bottom:4px;margin-top:10px;">
                            <h4 class="card-title">{{$name}} <span class="float-sm-right"><i class="mdi mdi-arrow-right-bold-circle"></i></span></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
