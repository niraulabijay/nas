@extends('admin.layouts.app')
@section('content')
<div class="modal right fade" id="quickViewModal" tabindex="-1"></div>
<div class="modal right fade" id="sendEmailModel" tabindex="-1"></div>
	<div class="row">
		<div class="col-md-12">
			<form id="make-all-read" action="{{ route('make-all-read') }}" method="post" style="display: none;">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
			</form>
			<a href="" onclick="
			if(confirm('Are you sure!!!'))
			{
				event.preventDefault();document.getElementById('make-all-read').submit();
			}
			else
			{
				event.preventDefault();
			}
			" class="btn btn-primary btn-xs pull-right" style="margin: 20px 0;">Mark all as read</a>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-straped table-hovered" id="contact_message">
			<thead>
				<tr>
					<th>S.N.</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Subject</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			{{--<tbody>--}}
				{{--@foreach($contacts as $contact)--}}
					{{--<tr>--}}
						{{--<td>{{ $loop->iteration }}</td>--}}
						{{--<td>{{ $contact->name }}</td>--}}
						{{--<td><a href="javascript::void(0);" data-id="{{ $contact->id }}" class="btn-send">{{ $contact->email }}</a></td>--}}
						{{--<td>{{ $contact->phone }}</td>--}}
						{{--<td>{{ $contact->subject }}</td>--}}
						{{--<td><span class="label label-{{ $contact->status == false ? 'Rejected':'Pending' }}">{{ $contact->status == false ? 'Unread Message':'Seen' }}</span></td>--}}
						{{--<td>--}}
							{{--<a href="javascript::void(0);" data-id="{{ $contact->id }}" class="btn btn-xs btn-info btn-view"><i class="fas fa-check-circle"></i> View Details</a>--}}
						{{--</td>--}}
					{{--</tr>--}}
				{{--@endforeach--}}
			{{--</tbody>--}}
		</table>
	</div>
@endsection
@push('scripts')
<script>

	$(document).ready(function(){
		$('#contact_message').DataTable({
			aaSorting: [0,'desc'],
			processing: true,
			serverSide: true,
			columns: [
				{
					"data": "id",
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{data: 'name', name:'name'},
				{
				    data: 'email',
					name: 'email',
                    render: function (data, type, row) {
                        return "<a href='javascript:void(0);' data-id=" + row.id + " class='btn-send'>" + row.email + "</a>";
                    }
				},
				{data: 'phone', name:'phone'},
				{data: 'subject', name:'subject'},
				{
				    data: 'status',
					name:'status',
                    render: function (data, type, row) {
                        return data === 0 ? '<span class="label label-Rejected"> Unread Message</span>' : ' <span class="label label-Pending"> Seen</span>';
                    }
				},
				{
					data: 'id',
					orderable: false,
					render: function (data, type, row) {
						var actions = '';
						actions += "<button type='submit' class='btn btn-xs btn-info btn-view' data-id=" + row.id + "><i class=\"fas fa-check-circle\"></i> View Details</button>";

						return actions;
					}
				}
			],
			ajax: '{{route('admin.contact.json')}}'

		});
	});
</script>
<script>
	var $modal = $('#quickViewModal');
	$(document).on("click", ".btn-view", function (e) {
		e.preventDefault();
		var $this = $(this);
		var id = $this.attr('data-id');
		var viewDetails = "{{ route('contact.edit', ':id') }}";                               
		viewDetails = viewDetails.replace(':id', id);
		$modal.load(viewDetails, function (response) {
			$modal.modal({show: true});
		});
	});
</script>
<script>
	var $modal = $('#sendEmailModel');
	$(document).on("click", ".btn-send", function (e) {
		e.preventDefault();
		var $this = $(this);
		var id = $this.attr('data-id');
		var viewDetails = "{{ route('contact.send', ':id') }}";                               
		viewDetails = viewDetails.replace(':id', id);
		$modal.load(viewDetails, function (response) {
			$modal.modal({show: true});
		});
	});
</script>
<script>
$(document).ready( function () {
    $('#contact_message').DataTable();
} );
</script>
@endpush