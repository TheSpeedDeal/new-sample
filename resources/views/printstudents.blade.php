<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <title>Document</title>
    <style>
        * {
           font-family: 'Courier New', Courier, monospace;
        }


        
    </style>
</head>
<body>
    <h1>USJ-R School of Computer Studies</h1>
    <h2>Student List</h2>
    <table>
        <tr>    
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Student Program</th>
            <th>Student Year</th>
        </tr> 
        @foreach($studentCollection as $student)
            <tr>
                <td>{{ $student->studid }}</td>
                <td>{{ $student->studlname }}, {{ $student->studfname }} {{ $student->studmname }}</td>
                <td>{{ $student->studprogram }}</td>
                <td>{{ $student->studyear }}</td>
            </tr>
        @endforeach
        <tr>
           <td colspan="6" id="nav-links">{{ $studentCollection->links() }}</td>
        </tr>    
    </table>
</body>
</html>