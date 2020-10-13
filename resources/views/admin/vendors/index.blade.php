@extends('admin.layouts.app')
@section('title', 'Vendors')

@section('content')
    <style>

        /*******************************
        * MODAL AS LEFT/RIGHT SIDEBAR
        * Add "left" or "right" in modal parent div, after class="modal".
        * Get free snippets on bootpen.com
        *******************************/
        .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 320px;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .modal.right .modal-body {
            padding: 15px 15px 80px;
        }

        /*Right*/
        .modal.right.fade .modal-dialog {
            right: -320px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }

        .modal.right.fade.in .modal-dialog {
            right: 0;
        }

        .modal-content {
            border-radius: 0;
            border: none;
        }

        .modal-header {
            border-bottom-color: #EEEEEE;
            background-color: #FAFAFA;
        }
    </style>
	<section>
		<div class="row">
			<h3>All Vendors</h3>
			<div class="col-xs-12 content__box content__box--shadow">
				<table class="table table-striped table-hover" id="vendorTable">
					<thead>
                        <tr>
                            <th>#</th>
                            <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Total Product</th>
                            <th>Date</th>
                            <th class="sorting-false">Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                     
				</table>
			</div>
		</div>
        <div class="modal right fade" id="vendorChat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        </div>
    </section>
@endsection

@push('scripts')
<script>
	$(document).ready(function() {
		$('#vendorTable').DataTable({
			 columnDefs: [
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1}
                ],
                processing: true,
                columns: [
                    {
                        "data": "id",
                       render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                       }
                    },
                    {
                        data: 'avatar',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" style="width: 100%; height:auto;">';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/admin/users/edit') }}' + '/' + row.id + '">' + row.user_name + '</a>';
                        }
                    },
                    {data: 'phone'},
                    {data: 'address'},
                    {data: 'totalProduct'},
                    {data: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempViewUrl = "{{ route('admin.vendor.stat', ':id') }}";

                            tempViewUrl = tempViewUrl.replace(':id', data);
 var tempDetailUrl = "{{ route('admin.vendor.configuration', ':id') }}";

                            tempDetailUrl = tempDetailUrl.replace(':id', data);

                            var actions = '';
                                                        actions += "<a href='"+ tempDetailUrl +"' class='btn btn-xs btn-default mr-5' target='_blank'>View Details</a>";

                            actions += "<a href='"+ tempViewUrl +"' class='btn btn-xs btn-default mr-5' target='_blank'>View Stat</a>";
                            // actions += "<a class='btn btn-xs btn-default btn-chat' data-id='" + row.id + "' data-toggle='modal'>Chat</a>";

                            return actions;
                        }
                    }
                ],
                ajax: "{{ route('admin.vendor.json') }}"
		});
	});
</script>

<script>
    var $modal = $('#vendorChat');
    $(document).on("click", ".btn-chat", function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        var tempChatUrl = "{{ route('admin.chat', ':id') }}";
        tempChatUrl = tempChatUrl.replace(':id', id);

        $modal.load(tempChatUrl, function (response) {
            $modal.modal({show: true});

        });
    });
</script>

<script>

    $(document).on("click", ".btn-send", function (e) {
        e.preventDefault();
        function refresh() {
            setTimeout(function () {
//                $('#chatBox').load(" #chatBox");
                refresh();
            }, 200);
        }

//        function sendMessage(){
//            // Get text message from input.
//            var newMessage = $('#chat-input').val();
//            // If input is empty on trying to send message, prevent sending.
//            if (newMessage == '') {
//                return false;
//            } else {
//                // Add to conversation.
//                $('<div style="background-color:#00aced;padding: 5px 10px; float: left; border-radius:20px;width: initial;max-width: 300px;word-wrap: break-word;" class="chat-conversation-body">' +
//                    '<span style="font-size:12px; color: #FFFFFF;" class="chat-item-last-message">'
//                    +newMessage+'</span></div>').appendTo('#chatBox');
////                $('')
//                // Clear input.
////                $('#chat-input').val('');
//            }
//        }
        var params   = $('#chat').serializeArray();
        var formData = new FormData($('#chat')[0]);
        if($('#image').val()) {
            formData.append('image', $('input[type=file]')[0].files[0]);
        }

        $.each(params, function(i, val) {
            formData.append(val.name, val.value);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.chat.vendor.store') }}",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            beforeSend: function (data) {
            },
            success: function (data) {
                $('#vendorChat').modal('hide');
//                $('#chatBox').load(" #chatBox");
//                window.location.reload();
//                 sendMessage();
//                refresh();
//                $('#chatBox').load();


            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                $("#chat")[0].reset();
//                $('#chatBox').load(" #chatBox");
//                $('#vendorChat').modal('show');
            }
        });
    });

    $( document ).ready(function() {
        var elem = document.getElementById('chatBox');
        elem.scrollTop = elem.scrollHeight// For Chrome, Firefox, IE and Opera
    });

    $('.product-img-zoom').magnificPopup({
        type: 'image'
        // other options
    });

    
</script>
</script>
@endpush