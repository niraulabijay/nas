<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="wrapper">
    @yield('content')
</div>
<!-- ./wrapper -->

<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
$('.print-window').click(function() {
    var prtContent = document.getElementById("print-invoice");
    window.print(prtContent.innerHTML);
});
</script>
</body>
</html>