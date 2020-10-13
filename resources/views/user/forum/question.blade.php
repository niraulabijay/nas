<div class="container">
    <form action="{{route('question.store')}}" method="post" >
        {{csrf_field()}}
        <textarea rows="4" cols="50" name="question">
            Enter Your Question Here
</textarea>
        <input type="submit" class="btn btn-danger">
    </form>
</div>