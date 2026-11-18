<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AbTestData;

class AbTestDataController extends Controller
{
    public function index() {
        $testdata = AbTestData::all();
        return view('testdata', ['testdata' => $testdata]);
    }
}
