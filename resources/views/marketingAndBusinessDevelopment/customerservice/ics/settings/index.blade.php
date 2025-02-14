@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer Service Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 10)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('serviceReport.index') }}">Intelligence Customer Service</a>
			</li>
<!-- 			<li class="nav-item">
				<a class="nav-link" href="">Cost Planning System</a>
			</li> -->
		</ul>
		<div class="card">
			<div class="card-header">Intelligence Customer Service<a href="{{ route('serviceReport.create') }}" class="btn btn-primary float-right">Add Service Report</a></div>
			<div class="card-body table-responsive"">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" href="{{ route('srConstant.index') }}">Settings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('customer.index') }}">Customer</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('machine_model.index') }}">Model</a>
					</li>
				</ul>
@include('marketingAndBusinessDevelopment.customerservice.ics.settings._content')
			</div>
		</div>


	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// date for ajax
$('#date').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
// .on('dp.change dp.show dp.update', function() {
	// $('#form').bootstrapValidator('revalidateField', 'date');
// })
;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$('#servicereportconstant1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "desc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

// $('#servicereportconstant1').colResizable({liveDrag:true});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection