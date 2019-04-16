<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function landing()
    {
        return view('frontend.landing');
    }

    public function landingSubmit(Request $request)
    {
        try {
            Contact::create($request->all());
            return redirect()->back();

        } catch (\Exception $exception) {
            file_put_contents(storage_path('debug.log'), $exception->getMessage(), FILE_APPEND);
            return redirect()->back();
        }
    }
}
