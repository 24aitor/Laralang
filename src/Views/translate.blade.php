@extends('laralang::template')
@section('title', 'Translate - Laralang')
@section('page_title', 'Translate files')
@section('nav_elements')
    <li style="padding-top:8px"><a href="{{ Aitor24\Linker\Facades\Linker::route('laralang::translations') }}">Translations</a></li>
    <li style="padding-top:8px"><a href="{{ Aitor24\Linker\Facades\Linker::route('laralang::filter') }}">Filter</a></li>
@endsection
@section('content')
<center>
<div class="container" style="padding-top:140px;padding-bottom:265px">
    <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="card card-block shadow">
            <br>
            <br>
            <div id="loader" style="display:none">
                Translating...&nbsp;&nbsp;&nbsp;
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Gray_circles_rotate.gif" style="height:60px;" alt="">
                <br><br><br>
            </div>
            <form method="POST" id="myform">
                {!! csrf_field() !!}
              <div class="form-group row">
                  <div class="col-sm-12 col-lg-12">
                      <button type="button" class="btn btn-primary btn-sm" id="btn-loader">Package translation</button>
                      <br>
                      <br>
                      <input type="hidden" class="form-control" id="is_package" name="is_package" value="0">
                      <div class="form-group">
                        <label for="package">Package</label>
                        <input type="text" class="form-control" id="package" disabled="true" name="package" placeholder="organization/module">
                      </div>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <div class="form-group">
                        <label for="path">Path of files</label>
                        <input type="text" class="form-control" id="path" name="path" value="lang/en">
                      </div>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <div class="form-group">
                        <label for="to_langs">Languages to translate</label>
                        <input type="text" class="form-control" id="to_langs" name="to_langs" value="es|fr|ca">
                      </div>
                  </div>
              </div>

              <br><button type="submit" class="btn btn-primary" id="btn-submit">Translate <i class="mdi mdi-translate"></i></button><br>
            </form>
            </div>
        </div>
        </div>
    </div>
</center>
@endsection
@section('js')
    <script>
        $(function() {
            $('#btn-loader').click(function() {

                if ($("#package").prop('disabled')) {
                    $("#package").prop('disabled', false);
                    $("#btn-loader").html('Project files translation');
                    $("#path").val('/src/Translations/en');
                    $("#is_package").val(1);
                } else {
                    $("#package").prop('disabled', true);
                    $("#btn-loader").html('Package translation');
                    $("#is_package").val(0);
                    $("#path").val('lang/en');
                }
            });
            $('#btn-submit').click(function() {
                    $("#myform").fadeOut();
                    $("#loader").fadeIn();
            });
        });
    </script>
@endsection
