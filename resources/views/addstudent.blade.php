<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Document</title>
    <style>
        body {
            font-size: 1.5rem;
        }

        label {
            display: inline-block;
            width: 300px;
        }

        #creation-form {
            margin: 0 auto;
            width: 1200px;
            height: 300px;
        }

        input, select {
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        select {
            width: 600px;
            text-overflow: ellipsis;
        }

        span {
            color: #f00;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <section id="creation-form">
    <h1>Add Student Information</h1>
    <form action="{{ route('students.save') }}" method="post">
            {{ csrf_field() }}
            {{-- <input type="hidden" name="_token" value='{{ csrf_token() }}'> --}}
            <label for="studid">
                Student ID:</label>
                <input type="text" name='studid' id='studid' value="{{ old('studid') }}">
                @foreach($errors->get('studid') as $errorMessage )
                    <span>{{ $errorMessage }}</span>
                @endforeach
            <br>
            <label for="studfname">
                First Name:</label>
                <input type="text" name='studfname' id='studfname' value="{{ old('studfname') }}">
                @foreach($errors->get('studfname') as $errorMessage )
                    <span>{{ $errorMessage }}</span>
                @endforeach              
            <br>
            <label for="studmname">
                Middle Name (optional): </label>
                <input type="text" name='studmname' id='studmname'>
           
            <br>            
            <label for="studlname">
                Last Name:</label>
                <input type="text" name='studlname' id='studlname' value="{{ old('studlname') }}">
                @foreach($errors->get('studlname') as $errorMessage )
                    <span>{{ $errorMessage }}</span>
                @endforeach            
            <br>
            <label for="studprogram">Program:</label>
            <select name="studprogram" id="studprogram">
                @php
                    $count = 1;
                @endphp
                @foreach($programs as $program)
                    @if(($count == 1) and (old('studprogram') <> $program['prog_sname']))
                        <option value="{{ $program['prog_sname'] }}" selected>{{ $program['prog_fname'] }}</option>  
                    @elseif(old('studprogram') === $program['prog_sname'])
                        <option value="{{ $program['prog_sname'] }}" selected>{{ $program['prog_fname'] }}</option>     
                    @else
                        <option value="{{ $program['prog_sname'] }}">{{ $program['prog_fname']}}</option>
                    @endif
                    @php
                       $count++;
                    @endphp
                @endforeach
            </select>
            
            <br>
            <label for="studyear">Year:</label>
            <select name="studyear" id="studyear">
                @php
                    $count = 1; 
                @endphp
                @foreach($years as $number => $words)
                    @if(($count == 1) and (old('studyear') <> $number))
                        <option value="{{ $number }}" selected>{{ $words }}</option>   
                    @elseif(old('studyear') == $number)    
                        <option value="{{ $number }}" selected>{{ $words }}</option>  
                    @else
                        <option value="{{ $number }}">{{ $words }}</option>
                    @endif
                    @php
                         $count++; 
                    @endphp
                @endforeach
            </select>
            
            <br>
            <button type='submit' class="btn btn-lg btn-primary">
                Add Student
            </button>
            <button type='reset' class="btn btn-lg btn-danger">
                Clear Values
            </button>
    </form>
    </section>
</body>
</html>