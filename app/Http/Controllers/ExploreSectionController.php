<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SectionExplore;
use Illuminate\Http\Request;

class ExploreSectionController extends Controller
{
    public function index()
    {
        $sections = SectionExplore::orderByDesc('order')->get();
        return response()->json($sections);
    }
}