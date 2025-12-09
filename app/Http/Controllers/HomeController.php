<?php

namespace App\Http\Controllers;

use App\View\Components\Categories\CategoriesCard;
use Illuminate\Http\Request;

use function Pest\Laravel\post;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //  Invoke controller is used because the home controller controls one task

        return view('home'
        //, [
        //     'categories' => Category(3)->get()
        // ]
        );
    }
}
