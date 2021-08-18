<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programme;

class ProgrammeController extends Controller
{
    public function getProgrammes($minimum = null)
    {
        if (!empty($minimum)) {
            $programmes = Programme::with('Agency')->where('margin', '>=', $minimum)->get();
            return $programmes->count() == 0 ? ['message' => 'There were no results found', 'properties' => $this->pluckProperties(Programme::with('Agency')->get())] : ['properties' => $this->pluckProperties($programmes)];
        } else {
            return ['properties' => $this->pluckProperties(Programme::with('Agency')->get())];
        }
    }

    public function createProgramme(Request $request)
    {
        $programme = new Programme();
        $programme->name = $request->name;
        $programme->margin = $request->margin;
        $programme->agency_id = null;
        $programme->save();
        return $programme->fresh();
    }

    private function pluckProperties($programmes)
    {
        $programmes->pluck('name', 'margin', 'agency');
        return $programmes->all();
    }
}
