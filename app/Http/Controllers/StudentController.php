<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Program;

// use Validator;
use Illuminate\Support\Facades\Validator;
USE Barryvdh\DomPDF\Facade\PDF;

class StudentController extends Controller
{

    private $years = [
        '1' => 'First Year',
        '2' => 'Second Year',
        '3' => 'Third Year',
        '4' => 'Fourth Year',
        '5' => 'Fifth Year' 
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo 'This is the index page for Students.';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $programs = Program::getProgramsByCollege(1);    

        // $programs = [
        //     'BSCS' => 'Bachelor of Science in Computer Science',     
        //     'BSIT' => 'Bachelor of Science in Information Technology',
        //     'BSEMC' => 'Bacheloor od Science in Entertainment and Multimedia Computing'
        // ];

        $years = $this->years;

        //
        return view('addstudent')->with(compact('programs','years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'studid' => 'required|regex:/[0-9]+/|unique:student,studid',
            'studfname' => 'required',
            'studlname' => 'required',
        ];  

        $messages = [
            'studid.required' => 'Please supply a student ID number.',
            'studid.regex' => 'Student ID should only be numeric.',
            'studid.unique' => 'Student ID already exists.',
            'studfname.required' => 'The First Name should not be empty.',
            'studlname.required' => 'The Last Name should not be empty.',
        ];

        $validation = Validator::make($request->input(),$rules,$messages);

        if($validation->fails()){    //$validation->passes()
            return redirect()->back()->withInput()->withErrors($validation); 
        } else {

            $newStudent = new Student;

            $newStudent->create([
                'studid' => $request->studid,
                'studfname' => $request->studfname,
                'studmname' => $request->studmname,
                'studlname' => $request->studlname,
                'studprogram' => $request->studprogram,
                'studyear' => $request->studyear
            ]); 
    
            return redirect()->to(route('students.all'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        // $studentData = Student::findOrFail($id);
        $studentData = Student::where('studid',$id)->get()->toArray();
        
        if($studentData){
            $studentData = $studentData[0];
            return view('found')->with(compact('studentData'));
        } else {
            return view('notfound');
        }    
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $programs = Program::getProgramsByCollege(1);

        $student = Student::findOrFail($id)->toArray();

        // dd($studentInformation);

        $years = $this->years;

        // dd($studentInformation);

        // echo 'Update student information.';

        return view('editstudent')->with(compact('student' ,'programs', 'years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'studfname' => 'required',
            'studlname' => 'required',
        ];  

        $messages = [
            'studfname.required' => 'The First Name should not be empty.',
            'studlname.required' => 'The Last Name should not be empty.',
        ];

        $validation = Validator::make($request->input(),$rules,$messages);

        if($validation->fails()){    //$validation->passes()
            return redirect()->back()->withErrors($validation); 
        } else {

            $updateStudent = Student::findOrFail($id);

            // $newStudent->studid = $request->studid;
            // $newStudent->studfname = $request->studfname;
            // $newStudent->studmname = $request->studmname; 
            // $newStudent->studlname = $request->studlname; 
            // $newStudent->studprogram = $request->studprogram;
            // $newStudent->studyear = $request->studyear;
    
            // $newStudent->save();

            $updateStudent->update([
                'studfname' => $request->studfname,
                'studmname' => $request->studmname,
                'studlname' => $request->studlname,
                'studprogram' => $request->studprogram,
                'studyear' => $request->studyear
            ]); 
    
            return redirect()->to(url('/home'));
    
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return redirect()->to(url('/home'));

    }

    public function showAll(){
        // $studentCollection = Student::get();

        $studentModel = new Student();
        $studentCollection = $studentModel->getAllStudents();

        $studentCollection = Student::getAllStudents();

        return view('showallstudents')->with(compact('studentCollection'));
    }

    public function printAllStudent(){
        $studentCollection = Student::getAllStudents();

        $pdf = PDF::setPaper('letter', 'portrait');
        $pdf->LoadView('printstudents', compact('studentCollection', 'pdf'));

        return $pdf->stream('studentlist.pdf',['Attachment'=> 1]);
    }

}
