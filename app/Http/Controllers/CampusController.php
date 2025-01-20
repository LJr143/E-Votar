<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\college;
use App\Models\Program;
use App\Models\program_major;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::all();

        if ($campuses->isEmpty()) {
            return response()->json(['message' => 'No campuses found.'], 404);
        }

        return response()->json($campuses);
    }
    public function getColleges($campusId)
    {
        $colleges = College::where('campus_id', $campusId)->get();
        return response()->json($colleges);
    }

    public function getPrograms($collegeId)
    {
        $programs = Program::where('college_id', $collegeId)->get();
        return response()->json($programs);
    }

    public function getMajors($programId)
    {
        $majors = Program_major::where('program_id', $programId)->get();
        return response()->json($majors);
    }

    public function getRoles()
    {
        $roles = \Spatie\Permission\Models\Role::where('name', '!=', 'voter')->get();

        return response()->json($roles);
    }

}
