@extends('laralang::template')
@section('title', 'Translations - Laralang')
@section('meta-sec')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<center>
<br><br>
<div class="container">
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<h1>Laralang</h1>
		</div>
		<div class="col-lg-3">
		<div class="btn-group">
		  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <i class="mdi mdi-settings"></i> Actions
		  </button>
		  <div class="dropdown-menu">
			  <center>
			<a href="{{ route('laralang::logout') }}" class='logout'>Logout</a>
			<div class="dropdown-divider"></div>
			<a href="#" class="delete-all-button" data-toggle="modal" data-target="#deleteAllTranslationModal">Delete All</a>
		</center>
		  </div>
		</div>
		</div>
		<br><br>
		<br><br>
		<br><br>
		<div class="container">
			<translations style="background-color:white;"></translations>
		</div>
	</div>
</div>
<br><br>
<a href="https://github.com/24aitor/laralang">Laralang on github</a>
<br><br>
</center>

<!-- Defining edit modal -->
<div class="modal fade" id="editTranslationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title modal-title-edit" id="exampleModalLabel"></h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">From locale:</label>
						<input type="text" class="form-control input-from" id="recipient-name">
					</div>

					<div class="form-group">
						<label for="recipient-name" class="form-control-label">To locale:</label>
						<input type="text" class="form-control input-to" id="recipient-name">
					</div>


					<div class="form-group">
						<label for="message-text" class="form-control-label">Input String:</label>
						<textarea class="form-control input-string" id="message-text"></textarea>
					</div>

					<div class="form-group">
						<label for="message-text" class="form-control-label">Translation:</label>
						<textarea class="form-control input-trans" id="message-text"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="edit">Submit</button>
				</center>
			</div>
		</div>
	</div>
</div>

<input hidden="hidden" class="trans-id"> <!-- This input is used to know current translation id -->

<!-- Defining delete modal -->
<div class="modal fade" id="deleteTranslationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title modal-title-delete" id="exampleModalLabel"></h4>
			</div>
			<div class="modal-body">
					<h6 for="message-text" class="form-control-label confirmation-message"></h6>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Submit</button>
				</center>
			</div>
		</div>
	</div>
</div>


<!-- Defining deleteall modal -->
<div class="modal fade" id="deleteAllTranslationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title modal-title-delete-all" id="exampleModalLabel">Delete all translations</h4>
			</div>
			<div class="modal-body">
					<h6 for="message-text" class="form-control-label confirmation-message-delete-all">Are you sure you want to delete all translations?</h6>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" id="delete-all-button-confirm">Submit</button>
				</center>
			</div>
		</div>
	</div>
</div>
@endsection

@section('templates')
<template id="translations-template">
	<table class="table">
	  <thead class="thead-inverse">
	    <tr>
	      <th>#</th>
	      <th>String</th>
	      <th>From</th>
		  <th>To</th>
		  <th>Translation</th>
		  <th>Last update</th>
	      <th colspan="2"><center>Settings</center></th>
	    </tr>
	  </thead>
	  <tbody>
	<tr v-for="translation in translations">
	      <th scope="row">@{{ translation.id }}</th>
	      <td>@{{ translation.string }}</td>
	      <td>@{{ translation.from_lang }}</td>
		  <td>@{{ translation.to_lang }}</td>
	      <td>@{{ translation.translation }}</td>
		  <td>@{{ translation.updated_at }}</td>
		  <td><center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editTranslationModal" v-on:click="storeData(translation.id, translation.string, translation.from_lang, translation.to_lang, translation.translation)">Edit</button></center></td>
		  <td><center><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteTranslationModal" v-on:click="storeData(translation.id, translation.string, translation.from_lang, translation.to_lang, translation.translation)">Delete</button></center></td>
	  </tr>
	  </tbody>
	</table>
</template>
@endsection
<!--
		<i class="mdi mdi-account" aria-hidden="true"></i>  -->
@section('js')
<script type="text/javascript">
Vue.component('translations', {
	template: '#translations-template',
	data: function() {
		return {
			translations: [],
		};
	},

	created: function() {
		this.getTranslations();
	},

	methods: {
		storeData: function (id, string, from, to, translation) {
			$('.trans-id').val(id);
			$('.modal-title-edit').html('Editing tranlsation #'+id);
			$('.modal-title-delete').html('Deleting tranlation #'+id);
			$('.input-from').val(from);
			$('.input-to').val(to);
			$('.input-string').html(string);
			$('.input-trans').html(translation);
			$('.confirmation-message').html('Are you sure you want to delete translation #' + id + ' ?');
		},


		getTranslations: function () {
			$.getJSON("{{ route('laralang::api')}}", function(translations) {
				translations.forEach(function(entry) {
					entry.updated_at = moment(entry.updated_at).fromNow();
				});
				this.translations = translations;
			}.bind(this));
			setTimeout(this.getTranslations,1000);
		}
	}
})
</script>
<script>
$( function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function notify_success(msg) {
		$.notify({
			icon: 'mdi mdi-check-circle',
			message: msg
		},{
			delay: 3000, type: 'success', placement: {from: "top", align: "left"},animate: {enter: 'animated fadeInLeft', exit: 'animated fadeOutLeft'}
		});
	}

	function notify_error(msg) {
		$.notify({
			icon: "mdi mdi-close-circle",
			message: msg
		},{
			delay: 5000, type: 'danger', placement: {from: "top", align: "left"}, animate: {enter: 'animated fadeInLeft', exit: 'animated fadeOutLeft'}
		});
	}

	$('#delete').click(function() {
		var trans_id = $('.trans-id').val();
		<?php $url_route = url('/').'/'.config('laralang.default.prefix').'/delete';
		?>
		$.ajax({
			type: "POST",
			url: "{{ $url_route }}",
			data: {id : trans_id},
			success: function() {
				notify_success("Translation #" + trans_id + ' deleted!');
			},
			error: function(){
				notify_error("Error succeed when trying to delete translation #" + trans_id + ' !');
			},
		});
	});

	$('#delete-all-button-confirm').click(function() {
		<?php $url_route = url('/').'/'.config('laralang.default.prefix').'/delete/all';
		?>
		$.ajax({
			type: "POST",
			url: "{{ $url_route }}",
			data: {},
			success: function() {
				notify_success('Deleted all translations');
			},
			error: function(){
				notify_error('Error succed when trying to delete all translations');
			},
		});
	});

	$('#edit').click(function() {
		var trans_id = $('.trans-id').val();
		<?php $url_route = url('/').'/'.config('laralang.default.prefix').'/edit';
		?>
		$.ajax({
			type: "POST",
			url: "{{ $url_route }}",
			data: {id : trans_id, from : $('.input-from').val(), to : $('.input-to').val(), string : $('.input-string').val(), translation : $('.input-trans').val()},
			success: function() {
				notify_success("Translation #" + trans_id + ' edited!');
			},
			error: function(){
				notify_error("Error succeed when trying to edit translation #" + trans_id + ' !');
			},
		});
	});

});
</script>
@endsection
