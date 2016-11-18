@extends('laralang::template')
@section('content')
<center>
<br><br>
<div class="container">
	<h1>Laralang</h1>
	<br><br>
	<div class="container">
		<translations style="background-color:white;"></translations>
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
					<button type="button" class="btn btn-danger" data-dismiss="modal" id="edit">Submit</button>
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
@endsection

@section('templates')
<template id="translations-template">
	<table class="table">
	  <thead class="thead-inverse">
	    <tr>
	      <th>#</th>
	      <th>String</th>
	      <th>From locale</th>
		  <th>To locale</th>
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
		  <td><center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editTranslationModal" v-on:click="storeID(translation.id, translation.string, translation.from_lang, translation.to_lang, translation.translation)">Edit</button></center></td>
		  <td><center><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteTranslationModal" v-on:click="storeID(translation.id, translation.string, translation.from_lang, translation.to_lang, translation.translation)">Delete</button></center></td>
	  </tr>
	  </tbody>
	</table>
</template>
@endsection

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
		storeID: function (id, string, from, to, translation) {
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
	$('#delete').click(function() {
		<?php $url_route = url('/').'/'.config('laralang.default.prefix').'/delete';
		?>
		$.get("{{ $url_route }}"+'/'+$('.trans-id').val());
	});
	$('#edit').click(function() {
		var translation = $('.input-trans').val();
		<?php $url_route = url('/').'/'.config('laralang.default.prefix').'/edit';
		?>
		$.get("{{ $url_route }}"+'/'+$('.trans-id').val()+'/'+translation);
	});

});
</script>
@endsection
