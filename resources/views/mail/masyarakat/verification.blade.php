<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi {{ config('app.name') }}</title>
</head>

<body>
    <div>
        <h1>Verifikasi {{ config('app.name') }} </h1>
        <p>
            Terima kasih telah mendaftar di {{ config('app.name') }}.<br>
            Silahkan klik link di bawah ini untuk verifikasi akun anda.
        </p>
        <a href="{{ route('front.verify', $token) }}">Verifikasi</a>
    </div>
</body>

</html>
