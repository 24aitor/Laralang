@extends('laralang::template')
@section('title', 'Translating - Laralang')
@section('page_title', 'Translating files...')
@section('content')
<center>
<div class="container" style="padding-top:140px;padding-bottom:265px">
    <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="card card-block shadow">
            <br>
            <br>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
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
        });
    </script>
@endsection
