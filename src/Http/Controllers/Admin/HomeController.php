<?php namespace Blupl\Board\Http\Controllers\Admin;

use Blupl\Franchises\Model\Franchise;
use Blupl\Franchises\Model\FranchiseManagement;
use Illuminate\Support\Facades\Input;
use Blupl\Franchises\Processor\Franchises as FranchisesProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class HomeController extends AdminController
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
        return $this->processor->index($this);
    }



}