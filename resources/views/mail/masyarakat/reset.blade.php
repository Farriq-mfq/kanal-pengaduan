<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <div>
        <h1>Reset Password {{ config('app.name') }} </h1>
        <p>
            Terima kasih telah mendaftar di {{ config('app.name') }}.<br>
            Silahkan klik link di bawah ini untuk reset password akun anda.
        </p>
        <a href="{{ route('front.auth.reset_password', $token) }}">Reset Password</a>
    </div>
</body>
</html>
