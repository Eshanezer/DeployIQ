<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\MainDevice;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Water;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = History::orderByDesc('id');
        if ($request->has('start') && $request->filled('start')) {
            $query->where('updated_at', '>=', $request->start);
        }
        if ($request->has('end') && $request->filled('end')) {
            $query->where('updated_at', '<', $request->end);
        }
        $data = $query->paginate(10);
        return view('pages.home', compact(['data']));
    }
}
