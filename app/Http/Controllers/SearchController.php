<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $videos = [];
        if ($search = $request->get('s')) {

            $videos = Video::where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")->with(['channel'])->get();
        }

        return view('search', compact($videos));
    }
}
