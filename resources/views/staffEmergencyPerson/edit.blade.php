@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Edit Emergency Contact Person</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staffEmergencyPerson, ['route' => ['staffEmergencyPerson.update', $staffEmergencyPerson->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('staffEmergencyPerson._form_edit')
{{ Form::close() }}


		
	</div>
</div>
@endsection

@section('js')/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', 'input', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#dob', function () {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {

		contact_person: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nama orang untuk dihubungi. '
				},
				regexp: {
					regexp: /^[a-z\s\'\@]+$/i,
					message: 'The full name can consist of alphabetical characters, \', @ and spaces only'
				},
			}
		},
		relationship: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan hubungan anda dengan penama diatas. '
				},
			}
		},
		address: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan alamat. '
				},
			}
		},
	}
});


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection