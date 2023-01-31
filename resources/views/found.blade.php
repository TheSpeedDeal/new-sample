<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <table>
        <tr>
           <th>Student ID</th>
           <td>{{ $studentData['studid'] }}</td> 
        </tr>
        <tr>
            <th>Student Name</th>
            <td>{{ $studentData['studlname'] }}, {{ $studentData['studfname'] }}</td>
        </tr>
        <tr>
            <th>Student Program</th>
            <td>{{ $studentData['studprogram'] }}</td>
        </tr>
        <tr>
            <th>Student Year</th>
            <td>{{ $studentData['studyear'] }}</td>
        </tr>
        <tr>
            <th><a href="{{ route('students.all')}}" title="Back">Back</a> </th>
        </tr>
    </table>
    
</body>
</html>