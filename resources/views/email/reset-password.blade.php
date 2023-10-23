<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    
    <h2>Hello, {{$formData['user']->name}}</h2>

    <h1>You have requested to reset your password:</h1>

    <p>Please click on the link below to reset your password</p>

    <a href="{{route('account.resetPassword',$formData['token'])}}">Click Here{{$formData['token']}}</a>

</body>
</html>