<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Kalaam;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index($slug = null)
    {
        $kalaam = DB::table('kalaam')->where('is_active', true)
            ->orderBy('sort_no', 'asc')
            ->get();


           $kalaams =  $kalaam;

        $current = null;

            if ($slug) {
                $current = Kalaam::where('slug', $slug)->first();
            }

            return view('home', compact('kalaams', 'current'));
    }

    public function show($slug)
    {
        $kalaam = DB::table('kalaam')->where('slug', $slug)
            ->where('is_active', true)
            ->first();
        return view('kalaam_show', compact('kalaam'));
    }
}
