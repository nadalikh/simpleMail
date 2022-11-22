<!doctype html>
<html lang="en">
<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple mail</title>
</head>
<body>
@if(!isset($sent))
    <form class="form-control d-block w-50 m-auto mt-3" method="post" action="{{action([\App\Http\Controllers\mailController::class, "sendVerificationCode"])}}">
        @csrf
        <input class="form-control mb-3" type="email" placeholder="test@test.com" name="email">
        <input class="form-control mb-3" type="submit" value="send verification code">
    </form>
@endif
@if(isset($sent))
    <form class="form-control d-block w-50 m-auto mt-3" method="post" action="{{action([\App\Http\Controllers\mailController::class, "checkVerificaitonCode"])}}">
        @csrf
        <input class="form-control mb-3" type="text" placeholder="*****" name="email">
        <input class="form-control mb-3" type="submit" value="check verification code">
    </form>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
</html>
