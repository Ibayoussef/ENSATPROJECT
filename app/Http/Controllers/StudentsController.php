<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\Document;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Students.index')->with('Students', Student::all())
            ->with('documents', Document::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.Students.create')->with('documents', Document::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Student::where("codedapogee", "=", $request->input("codedapogee"))->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'cin' => 'required',
            'codedapogee' => 'required',
            'doc_id' => 'required'
        ]);
        if ($check === null) {
            return redirect()->route("decline");
        } else {
            $Student = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'cin' => $request->cin,
                'codedapogee' => $request->codedapogee,
                'doc_id' => $request->doc_id,
            ]);

            return redirect()->route('null');
        }
    }
    public function null()
    {
        return view('null');
    }
    public function decline()
    {
        return view('decline');
    }


    public function destroy($id)
    {
    }

    public function kill($id)
    {
        $Students = Student::withTrashed()->where('id', $id)->first();
        $Students->forceDelete();
        session()->put('nope', 'request declined');
        return redirect()->route("maildec");
    }
    public function generatePDF($id)
    {

        $Student = Student::find($id);
        if ($Student->doc_id == "Attestation Scholaire") {


            $data = [
                'title' => $Student->doc_id,
                'name' => $Student->name,
                'codedapogee' => $Student->codedapogee,
                'cin' => $Student->cin,
                'email' => $Student->email
            ];
            $pdf = PDF::loadView('myPDF', $data);


            Mail::send('myPDF', $data, function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "attestation_scholaire.pdf");
            });

            $Student->delete();
            session()->put('notif', 'request accepted');
            return redirect()->back();
        } else {
            $data = [
                'title' => $Student->doc_id,
                'name' => $Student->name,
                'codedapogee' => $Student->codedapogee,
                'cin' => $Student->cin,
                'email' => $Student->email
            ];
            $pdf = PDF::loadView('Releve', $data);


            Mail::send('Releve', $data, function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "relevé_de_notes.pdf");
            });

            $Student->delete();
            session()->put('notif', 'request accepted');
            return redirect()->back();
        }
    }
}
