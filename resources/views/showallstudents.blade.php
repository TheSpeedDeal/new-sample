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
        table{
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        img {
           height: 30px;
           width: 30px; 
        }

        body {
            font-family: verdana;
            font-size: 1.5em;
        }

        .icons > a {
            margin-left: 1.5rem;
        }

        #nav-links {
            text-align: center;
        }
        #student{
            text-align: left;
        }
        td{
            text-align: center;
            padding-right: 20px;
        }
    </style>
</head>
<body>
    <table>
        <tr>    
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Student Program</th>
            <th>Student Year</th>
            <th><a href="{{ route('printstudents') }}" title="Edit Student Entry">Print</a> </th>
            <th><a href="{{ route('students.create') }}" title="Edit Student Entry">Create Student</a> </th>
            <th><a href="{{ route('signout')}}" title="Sign out">Sign out</a> </th>
        </tr> 
        @foreach($studentCollection as $student)
            <tr>
                <td><a href="{{ route('student.info',$student->studid)}}" title="{{$student->studid}}">{{$student->studid}}</a></td>
                <td id="student">{{ $student->studlname }}, {{ $student->studfname }} {{ $student->studmname }}</td>
                <td>{{ $student->studprogram }}</td>
                <td>{{ $student->studyear }}</td>
                <td class="nav-link"><a href="{{ route('student.edit',$student->studid) }}" title="Edit Student Entry">Edit</a></td>
                <td class="nav-link"><a href="{{ route('student.delete', $student->studid) }}" title="Delete Student Entry">Delete</a></td>
            </tr>
        @endforeach
        <tr>
           <td colspan="6" id="nav-links">{{ $studentCollection->links() }}</td>
        </tr>    
    </table>
</body>
</html>