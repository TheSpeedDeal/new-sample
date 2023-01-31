<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            padding-top: 50%vh;
            margin: 0 auto;
            text-align: center;
            font-size: 2em;
            font-family: verdana;
            font-weight: bold;
            color: #f00;
        }
    </style>
</head>
<body>
    The data you are searching does not exist.
    <br><br>
    <a href="{{ route('students.all')}}" title="Back">Back</a>
</body>
</html>