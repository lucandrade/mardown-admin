<?php declare(strict_types=1);

namespace App\Http\Controllers;

final class AdminController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
