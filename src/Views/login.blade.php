@extends('laralang::template')
@section('title', 'Login - Laralang')
@section('content')
<br><br><br>
<br>
<center>
<img src="{{asset('vendor/Aitor24/Laralang/Images/icon.png')}}" alt="Laralang logo" width="150">
<br>
<br><br><br><br>

<div class="container">
        <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
        <div class="card card-block">
              <br>
                  <h4 class="card-title">Laralang login</h4>
              <br>
              <form method="POST">
                {!! csrf_field() !!}
                  <div class="form-group row">
                    <div class="col-xs-10 offset-xs-1 col-lg-6 offset-lg-3">
                      <input class="form-control" placeholder="Enter password" type="password" name="password" id="password-input">
                          <small class="form-text" style="color:red;">{{ session('status') }}</small>
                    </div>
                  </div>
                  <br>
                    <button type="submit" class="btn btn-primary">Login <i class="mdi mdi-login"></i></button>
                  <br>
              </form>
        </div>
        </div>
        </div>
    </div>
<br><br><br>
<br><br><br>
</center>
@endsection
