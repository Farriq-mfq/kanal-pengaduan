<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .box {
            background-color: #f9f9f9;
            border-left: 5px solid #007bff;
            padding: 15px 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .status {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <p>Berikut adalah update terkini progress pengaduan pada
        <strong>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</strong>:
    </p>

    <a href="{{ route('front.aduan.tracking', ['nomer_aduan' => $tracking->aduan->nomer_aduan]) }}">
        {{ $tracking->aduan->nomer_aduan }}
    </a>
    <br>
    <div class="box">
        <p><span class="label">Step:</span><br />
            {{ $tracking->step }}
        </p>

        <p><span class="label">Status:</span>
            <span class="status">
                {{ $tracking->status }}
            </span>
        </p>

        <p><span class="label">Keterangan:</span><br />
            {{ $tracking->keterangan }}</p>

</body>

</html>
