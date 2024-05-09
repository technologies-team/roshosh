<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <style>
body {
    font-family: Arial, sans-serif;
        }

        .container {
    width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
        }

        h1 {
    color: #333;
    font-size: 24px;
            margin-bottom: 20px;
        }

        p {
    color: #555;
    font-size: 25px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Reset Password Code</h1>
    <p>Reset password code is : <strong>{{ $reset_code }}</strong></p>
</div>
</body>
</html>
