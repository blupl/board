<?php namespace Blupl\Franchises\Http\Controllers;

use Orchestra\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Get landing page.
     *
     * @return mixed
     */
    public function index()
    {

        return 'franchises';
    }
}