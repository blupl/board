<?php namespace Blupl\Franchises\Processor;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Blupl\Franchises\Model\FranchiseManagement as Eloquent;
use Orchestra\Contracts\Foundation\Foundation;
use Blupl\Franchises\Http\Presenters\ManagementPresenter as ManagementPresenter;
//use Blupl\Franchises\Validation\Franchise as FranchisesValidator;

class Management extends Processor
{
    /**
     * Setup a new processor instance.
     *
     */
    public function __construct(ManagementPresenter $presenter,  Foundation $foundation)
    {
        $this->presenter  = $presenter;
//        $this->validator  = $validator;
        $this->foundation = $foundation;
        $this->model = $foundation->make('Blupl\Franchises\Model\FranchiseManagement');


    }

    /**
     * View list roles page.
     *
     * @param  object  $listener
     *
     * @return mixed
     */
    public function index($listener)
    {
        $eloquent = $this->model->newQuery();
        $table    = $this->presenter->table($eloquent);

        $this->fireEvent('list', [$eloquent, $table]);

        // Once all event listening to `orchestra.list: role` is executed,
        // we can add we can now add the final column, edit and delete
        // action for roles.
        $this->presenter->actions($table);

        return $listener->indexSucceed(compact('eloquent', 'table'));
    }

    /**
     * View create a role page.
     *
     * @param  object  $listener
     *
     * @return mixed
     */
    public function create($listener)
    {
        $eloquent = $this->model;

        $form     = $this->presenter->form($eloquent);

        $this->fireEvent('form', [$eloquent, $form]);

        return $listener->createSucceed(compact('eloquent', 'form'));
        return $listener->createSucceed();
    }

    /**
     * View edit a role page.
     *
     * @param  object  $listener
     * @param  string|int  $id
     *
     * @return mixed
     */
    public function edit($listener, $id)
    {
        $eloquent = $this->model->findOrFail($id);
        $form     = $this->presenter->form($eloquent);

        $this->fireEvent('form', [$eloquent, $form]);

        return $listener->editSucceed(compact('eloquent', 'form'));
    }

    /**
     * Store a role.
     *
     * @param  object  $listener
     * @param  array   $input
     *
     * @return mixed
     */
    public function store($listener, $request)
    {
        $management = $this->model;

        try {
            $this->saving($management, $request, 'create');
        } catch (Exception $e) {
            return $listener->storeFailed(['error' => $e->getMessage()]);
        }

        return $listener->storeSucceed($management);
    }

    /**
     * Update a role.
     *
     * @param  object  $listener
     * @param  array   $input
     * @param  int     $id
     *
     * @return mixed
     */
    public function update($listener, $request, $id)
    {
        $management = $this->model->findOrFail($id);

        try {
            $this->saving($management, $request, 'update');
        } catch (Exception $e) {
            return $listener->updateFailed(['error' => $e->getMessage()]);
        }

        return $listener->updateSucceed($management);
    }

    /**
     * Delete a role.
     *
     * @param  object  $listener
     * @param  string|int  $id
     *
     * @return mixed
     */
    public function destroy($listener, $id)
    {
        $role = $this->model->findOrFail($id);

        try {
            DB::transaction(function () use ($role) {
                $role->delete();
            });
        } catch (Exception $e) {
            return $listener->destroyFailed(['error' => $e->getMessage()]);
        }

        return $listener->destroySucceed($role);
    }

    /**
     * Save the role.
     *
     * @param  \Orchestra\Model\Role  $role
     * @param  array  $input
     * @param  string  $type
     *
     * @return bool
     */
    protected function saving(Eloquent $management, $request, $type = 'create')
    {

        $beforeEvent = ($type === 'create' ? 'creating' : 'updating');
        $afterEvent  = ($type === 'create' ? 'created' : 'updated');

        $this->fireEvent($beforeEvent, [$management]);
        $this->fireEvent('saving', [$management]);


        if($type === 'create') :
            $management->create($request->all());
        else:
            $management->update($request->all());
        endif;

        $this->fireEvent($afterEvent, [$management]);
        $this->fireEvent('saved', [$management]);

        return true;
    }

    /**
     * Fire Event related to eloquent process.
     *
     * @param  string  $type
     * @param  array   $parameters
     *
     * @return void
     */
    protected function fireEvent($type, array $parameters = [])
    {
        Event::fire("blupl.management.{$type}: management", $parameters);
    }
}
