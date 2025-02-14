<?php
ini_set('max_execution_time', 1800);
use \App\Model\ICSServiceReport;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$now = Carbon::now();
$bor1 = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
$bor2 = $now->copy()->startOfYear()->format('Y-m-d');

$bmonth = $now->month;
// echo $bmonth.' month now <br />';
// echo $bor1.' now <br />';
// echo $bor1->copy()->subMonths(3)->startOfMonth().' from start of last month<br />';
$bor3 = $bor1->copy()->subMonths(3)->startOfMonth()->format('Y-m-d');

// echo $year.' year<br />';
if ( $bmonth != 1 ) {
	$sre = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1], ['approved_by', '<>', NULL]])->get();
	$srp = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1], ['approved_by',  NULL]])->get();
	$sr0 = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1]])->get();
} else {
	// if its in january, check the create date from early last month : 1 December, so can capture the sr.
	$sre = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1], ['approved_by', '<>', NULL]])->get();
	$srp = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1], ['approved_by',  NULL]])->get();
	$sr0 = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1]])->get();
}

?>
<div class="card">
	<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea;"':NULL !!}><h5>Appointment For Service</h5></div>
	<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff;"':NULL !!}>
		<table class="table table-hover table-sm" style="font-size:12px" id="servicereport1">
			<thead>
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Informed By</th>
					<th>SR No</th>
					<th>Customer</th>
					<th>Attendees</th>
					<th>Phone Number</th>
					<th>Complaints</th>
					<th>Approve By</th>
					<th>Remarks</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( $sr->hasmanyserial()->whereNull('serial')->first() )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td><strong>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</strong></td>
					<td><strong>{!! $sr->belongtoinformby->name !!}</strong></td>
					<td>
		<?php $u1 = 1 ?>
		@foreach( $sr->hasmanyserial()->get() as $srno )
						{{ $u1++ }}-<strong>{!! $srno->serial !!}</strong><br />
		@endforeach
					</td>
					<td>{!! $sr->belongtocustomer->customer !!}</td>
					<td>
		<?php $i1 = 1; ?>
		@foreach( $sr->hasmanyattendees()->get() as $sra )
						{!! $i1++ !!}. {!! $sra->belongtostaff->name !!}<br />
		@endforeach
					</td>
					<td>
		<?php $p0 = 1 ?>
		@foreach( $sr->hasmanyattendeesphone()->get() as $sra1 )
						{{ $p0++ }}. {{ $sra1->phone_number }}<br />
		@endforeach
					</td>
					<td>
		@foreach($sr->hasmanycomplaint()->get() as $src)
						{!! $src->complaint !!}
		@endforeach
					</td>

					<td>
		@if(!is_null($sr->belongtosendby))
						{{ $sr->belongtosendby->name }}
		@endif
					</td>
					<td>
						{!! $sr->remarks !!}
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.editkiv', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea;"':NULL !!}><h5>Service Report In Progress</h5></div>
	<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff;"':NULL !!}>
		<table class="table table-hover table-sm" style="font-size:12px" id="servicereport4">
			<thead>
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Informed By</th>
					<th>SR No</th>
					<th>Customer</th>
					<th>Attendees</th>
					<th>Phone Number</th>
					<th>Complaints</th>
					<th>Approve By</th>
					<th>Remarks</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( !$sr->hasmanyjob()->first() && (!$sr->hasmanyserial()->first() || !$sr->hasmanyserial()->whereNull('serial')->first()) )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
		<?php $i4 = 1?>
		@foreach( $sr->hasmanyserial()->get() as $srno )
						{!! $i4++ !!}-<strong>{!! $srno->serial !!}</strong><br />
		@endforeach
					</td>
					<td><strong>{!! $sr->belongtocustomer->customer !!}</strong></td>
					<td>
		<?php $i2 = 1 ?>
		@if($sr->hasmanyattendees()->get()->count())
		@foreach( $sr->hasmanyattendees()->get() as $sra )
						{!! $i2++ !!}. {!! $sra->belongtostaff->name !!}<br />
		@endforeach
		@endif
					</td>
					<td>
		<?php $p0 = 1 ?>
		@foreach( $sr->hasmanyattendeesphone()->get() as $sra1 )
						{{ $p0++ }}. {{ $sra1->phone_number }}<br />
		@endforeach
					</td>

					<td>
		@foreach($sr->hasmanycomplaint()->get() as $src)
						{!! $src->complaint !!}
		@endforeach
					</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if( $di->group_id == 1 || $di->id == 29 )
				@if(!is_null($sr->approved_by))
								{{ $sr->belongtoapprovedby->name }}
				@else
								<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
				@endif
		@else
						Only Director or HOD can approve
		@endif
					</td>
					<td>
						{!! $sr->remarks !!}
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<a href="{!! route('printpdfsr.show', $sr->id) !!}" title="Print" target="_blank"><i class="fas fa-print"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea;"':NULL !!}><h5>Completed Service Report for Customer Service Department</h5></div>
	<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff;"':NULL !!}>
		<table class="table table-hover table-sm" style="font-size:12px" id="servicereport5">
			<thead>
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Category</th>
					<th>Informed By</th>
					<th>SR No</th>
					<th>Customer</th>
					<th>Attendees</th>
					<th>Complaints</th>
					<th>Date Completed</th>
					<th>Proceed</th>
					<th>Status</th>
					<th>Approve By</th>
					<th>Checked By</th>
					<th>Send By</th>
					<th>Remarks</th>
					<th>Invoice</th>
					<th>Calls</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( $sr->hasmanyjob()->first() )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtocategory->sr_category !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
		<?php $i5 = 1 ?>
		@foreach( $sr->hasmanyserial()->get() as $srno )
						{!! $i5++ !!}-<strong>{!! $srno->serial !!}</strong><br />
		@endforeach
					</td>
					<td><strong>{!! $sr->belongtocustomer->customer !!}</strong></td>
					<td>
		<?php $i3 = 1 ?>
		@if($sr->hasmanyattendees()->get()->count())
		@foreach( $sr->hasmanyattendees()->get() as $sra )
						{!! $i3++ !!}. {!! $sra->belongtostaff->name !!}<br />
		@endforeach
		@endif
					</td>
					<td>
		@foreach($sr->hasmanycomplaint()->get() as $src)
						{!! $src->complaint !!}
		@endforeach
					</td>
					<td>
		@if( !is_null( $sr->hasmanyjob()->first() ) )
						{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtoproceed) )
						{!! $sr->belongtoproceed->proceed !!}
		@endif
					</td>
					<td>{!! $sr->belongtostatus->sr_status !!}</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if(!is_null($sr->approved_by))
						{{ $sr->belongtoapprovedby->name }}
		@else
						<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
		@endif
					</td>
					<td>
		@if(!is_null( $sr->checked_by ))
						{{ $sr->belongtocheckedby->name }}
		@endif
					</td>
					<td>
		@if(!is_null($sr->send_by))
						{{ $sr->belongtosendby->name }}
		@else
			@if( !is_null($sr->checked_by) )
				@if($sr->proceed_id == 5)
					FOC Service Report
				@else
					<div class="send text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
				@endif
			@else
				Havent been checked yet
			@endif
		@endif
					</td>
					<td>
						{!! $sr->remarks !!}
					</td>
					<td>
		@if( !is_null( $sr->belongtoinvoice ))
						{!! $sr->belongtoinvoice->DocNo !!}
		@else
						{!! __('No Invoice') !!}
		@endif
					</td>
					<td>
		@if($sr->hasmanyfeedcall()->get()->count() > 0)
		<?php $i10 = 1 ?>
		@foreach($sr->hasmanyfeedcall()->get() as $sccallc)
						{!! $i10++ !!}) {!! Carbon::parse($sccallc->date)->format('j M Y') !!}<br />
		@endforeach
		@else
			@if($sr->status_id == 1)
						{!! __('No Courtesy Call Yet') !!}
			@endif
		@endif
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.floatth', $sr->id) !!}" target="_blank" title="FLOAT-TH"><i class="far fa-money-bill-alt"></i></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
		@if($sr->status_id == 1)
						<span class="text-primary courtesycall" title="Courtesy Calls" data-id="{!! $sr->id !!}"><i class="fas fa-phone-volume"></i></span>
		@endif
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea;"':NULL !!}><h5>Service Report Feedback</h5></div>
	<div class="card-body"  {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff;"':NULL !!}>

		<table class="table table-hover table-sm" style="font-size:12px" id="servicereport6">
			<thead>
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Category</th>
					<th>SR No</th>
					<th>Customer</th>
					<th>Attendees</th>
					<th>Problem Detect On Site</th>
					<th>Additional Request (Order Part, Request For Next Service)</th>
					<th>Item Bring Back To IPMA</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( $sr->hasmanyfeedproblem()->get()->count() > 0 || $sr->hasmanyfeedrequest()->get()->count() > 0 || $sr->hasmanyfeeditem()->get()->count() > 0 )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtocategory->sr_category !!}</td>
					<td>
		<?php $i5 = 1 ?>
		@foreach( $sr->hasmanyserial()->get() as $srno )
						{!! $i5++ !!}-<strong>{!! $srno->serial !!}</strong><br />
		@endforeach
					</td>
					<td><strong>{!! $sr->belongtocustomer->customer !!}</strong></td>
					<td>
		<?php $i3 = 1 ?>
		@if($sr->hasmanyattendees()->get()->count())
		@foreach( $sr->hasmanyattendees()->get() as $sra )
						{!! $i3++ !!}. {!! $sra->belongtostaff->name !!}<br />
		@endforeach
		@endif
					</td>
 					<td>
@if($sr->hasmanyfeedproblem()->get()->count() > 0)
						<table class="table table-hover table-sm" style="font-size:12px">
							<thead>
								<tr>
									<th>Problem</th>
									<th>Solution</th>
								</tr>
							</thead>
							<tbody>
@foreach($sr->hasmanyfeedproblem()->get() as $srpp)
								<tr>
									<td>{{ $srpp->problem }}</td>
									<td>{{ $srpp->solution }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
@else
							No Data
@endif
					</td>
					<td>
@if($sr->hasmanyfeedrequest()->get()->count() > 0)
						<table class="table table-hover table-sm" style="font-size:12px">
							<thead>
								<tr>
									<th>Request</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
@foreach($sr->hasmanyfeedrequest()->get() as $srfr)
								<tr>
									<td>{{ $srfr->request }}</td>
									<td>{{ $srfr->action }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
@else
							No Data
@endif					
					</td>
					<td>
@if($sr->hasmanyfeeditem()->get()->count() > 0)
							<table class="table table-hover table-sm" style="font-size:12px">
								<thead>
									<tr>
										<th>Item</th>
										<th>Quantity</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
@foreach($sr->hasmanyfeeditem()->get() as $srfi)
									<tr>
										<td>{{ $srfi->item }}</td>
										<td>{{ $srfi->quantity }}</td>
										<td>{{ $srfi->item_action }}</td>
									</tr>
@endforeach
								</tbody>
							</table>
@else
							No Data
@endif
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.floatth', $sr->id) !!}" target="_blank" title="FLOAT-TH"><i class="far fa-money-bill-alt"></i></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
		@if($sr->status_id == 1)
						<span class="text-primary courtesycall" title="Courtesy Calls" data-id="{!! $sr->id !!}"><i class="fas fa-phone-volume"></i></span>
		@endif
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>

	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea;"':NULL !!}><h5>Unapproved Service Report</h5></div>
	<div class="card-body"  {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff;"':NULL !!}>

{!! Form::open(['route' => ['serviceReport.updateunapprove'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true,  'data-toggle' => 'validator']) !!}
		<table class="table table-hover table-sm" style="font-size:12px" id="servicereport3">
			<thead>
				<tr>
					<th>
						<input type="checkbox" id="selectAll">
						<label for="selectAll">Approved All</label>
					</th>
					<th>ID</th>
					<th>Date</th>
					<th>Informed By</th>
					<th>SR No</th>
					<th>Customer</th>
					<th>Attendees</th>
					<th>Complaints</th>
					<th>Date Completed</th>
					<th>Vehicle</th>
					<th>Proceed</th>
					<th>Approve By</th>
					<th>Remarks</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($srp as $sr)
				<tr>
					<td>
						<label for="cb{{ $sr->id }}"><input type="checkbox" value="{{ $sr->id }}" name="approved_by[]" id="cb{{ $sr->id }}" class="checkbox1">&nbsp;</label>
					</td>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
		<?php $i6 = 1 ?>
		@foreach( $sr->hasmanyserial()->get() as $srno )
						{!! $i6++ !!}-<strong>{!! $srno->serial !!}</strong><br />
		@endforeach
					</td>
					<td>{!! $sr->belongtocustomer->customer !!}</td>
					<td>
		<?php $i4 = 1 ?>
		@if($sr->hasmanyattendees()->get()->count())
		@foreach( $sr->hasmanyattendees()->get() as $sra )
						{!! $i4++ !!}. {!! $sra->belongtostaff->name !!}<br />
		@endforeach
		@endif
					</td>
					<td>
		@foreach($sr->hasmanycomplaint()->get() as $src)
						{!! $src->complaint !!}
		@endforeach
					</td>
					<td>
		@if( !is_null( $sr->hasmanyjob()->first() ) )
						{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtovehicle) )
						{!! $sr->belongtovehicle->vehicle !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtoproceed) )
						{!! $sr->belongtoproceed->proceed !!}
		@endif
					</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if( $di->group_id == 1 || $di->id == 29 )
						<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
		@else
						Only Director or HOD can approve
		@endif
					</td>
					<td>
						{!! $sr->remarks !!}
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="14">
						{!! Form::button('Approved All', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</td>
				</tr>
			</tfoot>
		</table>
{{ Form::close() }}
	</div>
</div>

<p>&nbsp;</p>
