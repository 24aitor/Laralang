@extends('laralang::template')
@section('title', 'Filter - Laralang')
@section('page_title', 'Filter')
@section('nav_elements')
<li style="padding-top:8px"><a href="{{ route('laralang::translations') }}">Translations</a></li>
@endsection
@section('content')
<center>
<div class="container" style="padding-top:140px;padding-bottom:265px">
    <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="card card-block shadow">
            <br>
            <br>
            <form method="POST">
                {!! csrf_field() !!}
              <div class="form-group row">
                  <div class="col-sm-12 col-lg-6">
                  <label for="select-from">From:</label>
                  <select class="custom-select" id="select-from" name="from_lang">
                    <option value="all" selected>All languages</option>
                    @foreach($languagesFrom as $lang)
                        <option value="{{$lang}}">{{$lang}}</option>
                    @endforeach
                  </select>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <label for="select-to">To:</label>
                  <select class="custom-select" id="select-to" name="to_lang">
                    <option value="all" selected>All languages</option>
                    @foreach($languagesTo as $lang)
                        <option value="{{$lang}}">{{$lang}}</option>
                    @endforeach
                  </select>
                  </div>
              </div>

              <br><button type="submit" class="btn btn-primary">Filter <i class="mdi mdi-filter"></i></button><br>
            </form>
            </div>
        </div>
        </div>
    </div>
</center>
@endsection
