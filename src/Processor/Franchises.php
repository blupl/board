<?php namespace Blupl\Franchises\Processor;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Blupl\Franchises\Model\Franchise as Eloquent;
use Orchestra\Contracts\Foundation\Foundation;
use Blupl\Franchises\Http\Presenters\FranchisesPresenter as FranchisesPresenter;
//use Blupl\Franchises\Validation\Franchise as FranchisesValidator;

class Franchises extends Processor
{
    /**
     * Setup a new processor instance.
     *
     */
    public function __construct(FranchisesPresenter $presenter,  Foundation $foundation)
    {
        $this->presenter  = $presenter;
//        $this->validator  = $validator;
        $this->foundation = $foundation;
        $this->model = $foundation->make('Blupl\Franchises\Model\Franchise');


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
        $franchise = $this->model;

        try {
            $this->saving($franchise, $request, 'create');
        } catch (Exception $e) {
            return $listener->storeFailed(['error' => $e->getMessage()]);
        }

        return $listener->storeSucceed($franchise);
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
        $franchise = $this->model->findOrFail($id);

        try {
            $this->saving($franchise, $request, 'update');
        } catch (Exception $e) {
            return $listener->updateFailed(['error' => $e->getMessage()]);
        }

        return $listener->updateSucceed($franchise);
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
    protected function saving(Eloquent $franchise, $request, $type = 'create')
    {

        $beforeEvent = ($type === 'create' ? 'creating' : 'updating');
        $afterEvent  = ($type === 'create' ? 'created' : 'updated');

        $this->fireEvent($beforeEvent, [$franchise]);
        $this->fireEvent('saving', [$franchise]);


        if($type === 'create') :
            $franchise->create($request->all());
        else:
            $franchise->update($request->all());
        endif;

        $this->fireEvent($afterEvent, [$franchise]);
        $this->fireEvent('saved', [$franchise]);

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
        Event::fire("blupl.franchise.{$type}: franchise", $parameters);
    }
}
