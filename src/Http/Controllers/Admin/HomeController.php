<?php namespace Blupl\Franchises\Http\Controllers\Admin;

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

    public function accredit_home()
    {
        return view ('blupl/franchises::accredithome');
    }

    public function indexSucceed(array $data)
    {
        set_meta('title', 'blupl/franchises::title.franchises');

        return view('blupl/franchises::index', $data);
    }


    /**
     * Show a role.
     *
     * @param $franchises
     * @return mixed
     * @internal param int $roles
     *
     */
    public function show($franchises)
    {
        return $this->edit($franchises);
    }

    /**
     * Create a new role.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
     public function edit($franchises)
     {
        return $this->processor->edit($this, $franchises);
     }

    /**
     * Create the role.
     *
     * @return mixed
     */
     public function store()
     {
        return $this->processor->store($this, Input::all());
     }

    /**
     * Update the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update($franchises)
    {
        return $this->processor->update($this, Input::all(), $franchises);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed;
     */
    public function delete($franchises)
    {
        return $this->destroy($franchises);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy($franchises)
    {
        return $this->processor->destroy($this, $franchises);
    }


    /**
     * Response when create role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function createSucceed(array $data)
    {
        set_meta('title', trans('blupl/franchises::title.franchises.create'));

        return view('blupl/franchises::edit', $data);
    }

    /**
     * Response when edit role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function editSucceed(array $data)
    {
        set_meta('title', trans('blupl/franchises::title.franchises.update'));

        return view('blupl/franchises::edit', $data);
    }

    /**
     * Response when storing role failed on validation.
     *
     * @param  object  $validation
     *
     * @return mixed
     */
     public function storeValidationFailed($validation)
     {
        return $this->redirectWithErrors(handles('orchestra::franchises/reporter/create'), $validation);
     }

    /**
     * Response when storing role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
     public function storeFailed(array $error)
     {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::franchises/reporter'), $message);
     }

    /**
     * Response when storing user succeed.
     *
     * @param franchises $franchises
     * @return mixed
     * @internal param \Orchestra\Model\Role $role
     *
     */
     public function storeSucceed(franchises $franchises)
     {
        $message = trans('blupl/franchises::response.franchises.create', [
            'name' => $franchises->getAttribute('name')
        ]);

            return $this->redirectWithMessage(handles('orchestra::franchises/reporter'), $message);
     }

    /**
     * Response when updating role failed on validation.
     *
     * @param  object  $validation
     * @param  int     $id
     *
     * @return mixed
     */
     public function updateValidationFailed($validation, $id)
     {
        return $this->redirectWithErrors(handles("orchestra::franchises/reporter/{$id}/edit"), $validation);
     }

    /**
     * Response when updating role failed.
     *
     * @param  array  $errors
     *
     * @return mixed
     */
     public function updateFailed(array $errors)
     {
        $message = trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(handles('orchestra::franchises/reporter'), $message);
     }

    /**
     * Response when updating role succeed.
     */
    public function updateSucceed(franchises $franchises)
    {
        $message = trans('orchestra/control::response.roles.update', [
            'name' => $franchises->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::franchises'), $message);
    }

    /**
     * Response when deleting role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
    public function destroyFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::franchises'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param franchises $franchises
     * @return mixed
     * @internal param \Orchestra\Model\Role $role
     *
     */
    public function destroySucceed(franchises $franchises)
    {
        $message = trans('orchestra/control::response.roles.delete', [
            'name' => $franchises->getAttribute('name')
        ]);

   ;     return $this->redirectWithMessage(handles('orchestra::franchises'), $message);
    }

    /**
     * Response when user verification failed.
     *
     * @return mixed
     */
    public function userVerificationFailed()
    {
        return $this->suspend(500);
    }

}