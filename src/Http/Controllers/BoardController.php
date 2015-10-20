<?php namespace Blupl\Franchises\Http\Controllers;


use Blupl\Franchises\Processor\Franchises as FranchisesProcessor;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Orchestra\Foundation\Http\Controllers\AdminController;

class BoardController extends AdminController
{

    public function __construct(FranchisesProcessor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    protected function setupFilters()
    {
        $this->beforeFilter('control.csrf', ['only' => 'delete']);
    }

    /**
     * Get landing page.
     *
     * @return mixed
     */
    public function index()
    {

    }


}