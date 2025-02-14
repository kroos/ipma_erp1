<div class="card">
	<div class="card-header">Add Holiday Calendar</div>
	<div class="card-body">

		<div class="row">
			{{ Form::label( 'yea', 'Date Range (Including Sunday) : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="form-group col-sm-5 {{ $errors->has('date_start')?'has-error':'' }}">
				{{ Form::text('date_start', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
			</div>
			<div class="form-group col-sm-5{{ $errors->has('date_end')?'has-error':'' }}">
				{{ Form::text('date_end', @$value, ['class' => 'form-control', 'id' => 'dend', 'placeholder' => 'Date End', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('holiday')?'has-error':'' }}">
			{{ Form::label( 'hol', 'Holiday : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('holiday', @$value, ['class' => 'form-control', 'id' => 'hol', 'placeholder' => 'Holiday', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
