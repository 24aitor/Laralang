@extends('laralang::template')
@section('title', 'Login - Laralang')
@section('content')
    <div class="container" style="margin-top:10%">
        <div class="row">
            <div class="col-xs-12 col-lg-8 offset-lg-2">
                <div class="card card-block shadow">
                    <br>
                    <center>
                        <img src="http://i.imgur.com/kcb4uhE.png" alt="Laralang logo" width="150">
                        <br><br><br>
                        <h3 class="card-title">Laralang</h3>
                        <h5 class="card-title">Login</h5>
                    </center>
                    <form method="POST">
                        {!! csrf_field() !!}
                        <div class="form-group row">
                            <div class="col-xs-12 col-lg-8 offset-lg-1" style="padding-top:15px">
                                <center>
                                    <input class="form-control" placeholder="Enter password" type="password" name="password" id="password-input">
                                </center>
                            </div>
                            <div class="col-xs-12 col-lg-2" style="padding-top:15px">
                                <center>
                                    <button type="submit" class="btn btn-primary">Login <i class="mdi mdi-login"></i></button><br>
                                </center>
                            </div>
                            <br><br><br>
                            <center>
                                <small class="form-text" style="color:red;">{{ session('status') }}</small>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
