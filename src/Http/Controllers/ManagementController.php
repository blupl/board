<?php namespace Blupl\Franchises\Http\Controllers;

use Blupl\Franchises\Model\FranchiseManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Blupl\Franchises\Processor\Management as ManagementProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class ManagementController extends AdminController
{

    public function __construct(ManagementProcessor $processor)
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

    public function indexSucceed(array $data)
    {
        set_meta('title', 'blupl/franchises::title.franchises');

        return view('blupl/franchises::index', $data);
    }


    /**
     * Show a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function show($management)
    {
        return $this->edit($management);
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
    public function edit($management)
    {
        return $this->processor->edit($this, $management);
    }

    /**
     * Create the role.
     *
     * @return mixed
     */
    public function store(Request $request )
    {
        return $this->processor->store($this, $request);
    }

    /**
     * Update the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update($management, Request $request)
    {
        return $this->processor->update($this, $request, $management);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed;
     */
    public function delete($management)
    {
        return $this->destroy($management);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy($management)
    {
        return $this->processor->destroy($this, $management);
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
//    public function storeValidationFailed($validation)
//    {
//        return $this->redirectWithErrors(handles('orchestra::franchises/reporter/create'), $validation);
//    }

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

        return $this->redirectWithMessage(handles('blupl::franchise/management'), $message);
    }

    /**
     * Response when storing user succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function storeSucceed(FranchiseManagement $franchise)
    {
        $message = trans('blupl/franchises::response.franchises.create Management Saved!', [
            'name' => $franchise->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('blupl::franchise/management'), $message);
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
        return $this->redirectWithErrors(handles("blupl::franchise/management/{$id}/edit"), $validation);
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

        return $this->redirectWithMessage(handles('blupl::franchise/management'), $message);
    }

    /**
     * Response when updating role succeed.
     */
    public function updateSucceed(FranchiseManagement $franchise)
    {
        $message = trans('orchestra/control::response.roles.update', [
            'name' => $franchise->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('blupl::franchise/management'), $message);
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
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function destroySucceed(franchises $management)
    {
        $message = trans('orchestra/control::response.roles.delete', [
            'name' => $management->getAttribute('name')
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