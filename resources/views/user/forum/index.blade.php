@extends('layouts.app')
@section('content')


<div class="container">
    <center>
    <h3>        {{$forum->user->email}}
    </h3>

    <h2>
        {{$forum->question}}
    </h2>

    </center>
    <form action="{{route('answer.store',['id'=>$forum->id])}}" method="post" >
        {{csrf_field()}}
        <textarea rows="4" cols="50" name="answer">
            Enter Your Question Here
</textarea>
        <input type="submit" class="btn btn-danger">
    </form>
    @foreach($forum->answers as $comment)
        <p>
            <a href="{{route('like',['id'=>$comment->id,'value'=>'like'])}}">  Likes: {{$comment->likes->where('vote',1)->count()}}
            </a><br>
     {{$comment->user->name}}
    <br>
           {{$comment->answer}}
        <br>
            <a href="{{route('like',['id'=>$comment->id,'value'=>'dislike'])}}">   Dislikes: {{$comment->likes->where('vote',0)->count()}}
            </a>   <br>
        </p>
        @endforeach


</div>
    @endsection
@push('scripts')
<script>
    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('brands.delete', ':id') }}";                               tempDeleteUrl = tempDeleteUrl.replace(':id', id);




        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: tempDeleteUrl,
            data: id,
            beforeSend: function (data) {
            },
            success: function (data) {

                // $('#myTable').DataTable().ajax.reload();

            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                $('#myTable').DataTable().ajax.reload();


            }
        });


    });

</script>



@endpush
