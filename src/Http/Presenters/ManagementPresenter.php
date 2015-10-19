<?php namespace Blupl\Franchises\Http\Presenters;

use Orchestra\Html\Form\Fieldset;
use Blupl\Franchises\Model\FranchiseManagement as Eloquent;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Factory as FormFactory;
use Orchestra\Contracts\Html\Table\Builder as TableBuilder;
use Orchestra\Contracts\Html\Table\Factory as TableFactory;

class ManagementPresenter extends Presenter
{
    /**
     * Implement of config contract.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new Role presenter.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Orchestra\Contracts\Html\Form\Factory  $form
     * @param  \Orchestra\Contracts\Html\Table\Factory  $table
     */
    public function __construct(Repository $config, FormFactory $form, TableFactory $table)
    {
        $this->config = $config;
        $this->form   = $form;
        $this->table  = $table;
    }

    /**
     * View table generator for Orchestra\Model\Role.
     *
     * @param  \Orchestra\Model\Role|\Illuminate\Pagination\Paginator  $model
     *
     * @return \Orchestra\Contracts\Html\Table\Builder
     */
    public function table($model)
    {
        return $this->table->of('management', function (TableGrid $table) use ($model) {
            // attach Model and set pagination option to true.
            $table->with($model)->paginate(true);

            $table->sortable();
            $table->searchable(['name_franchise']);

            $table->layout('orchestra/foundation::components.table');

            // Add columns.
            $table->column(trans('orchestra/foundation::label.name'), 'name_franchise');
            $table->column('Phone', 'phone');
            $table->column('Address', 'address');

            $table->attributes(['class' => 'table table-striped responsive-utilities jambo_table']);

        });
    }

    /**
     * Table actions View Generator for Orchestra\Model\User.
     *
     * @param  \Orchestra\Contracts\Html\Table\Builder  $table
     *
     * @return \Orchestra\Contracts\Html\Table\Builder
     */
    public function actions(TableBuilder $table)
    {
        return $table->extend(function (TableGrid $table) {
            $table->column('action')
                ->label('Action')
                ->escape(false)
                ->attributes(function () {
                    return ['class' => 'th-action'];
                })
                ->value(function ($row) {
                    $html = [
                        app('html')->link(
                            handles("blupl::franchise/registration/{$row->id}/edit"),
                            trans('orchestra/foundation::label.edit'),
                            ['class' => 'btn btn-xs btn-warning']
                        ),
                    ];

                    $roles = [
                        (int) $this->config->get('orchestra/foundation::franchises.admin'),
                        (int) $this->config->get('orchestra/foundation::franchises.member'),
                    ];

                    if (! in_array((int) $row->id, $roles)) {
                        $html[] = app('html')->link(
                            handles("blupl::franchise/management/{$row->id}/delete", ['csrf' => true]),
                            trans('orchestra/foundation::label.delete'),
                            ['class' => 'btn btn-xs btn-danger']
                        );
                    }

                    return app('html')->create('div', app('html')->raw(implode('', $html)), ['class' => 'btn-group']);
                });
        });
    }

    /**
     * View form generator for Orchestra\Model\Role.
     *
     */
    public function form(Eloquent $model)
    {

        return $this->form->of('franchise.management', function (FormGrid $form) use ($model) {
            $form->resource($this, 'blupl/franchise::management', $model);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:select', 'accredit_category')
                    ->options(['name'=>'Franchise'], 'name')
                    ->label('Accreditation Category');
                $fieldset->control('input:text', 'name_franchise')
                    ->label('Name of Franchise');
                $fieldset->control('input:text', 'name_applicant')
                    ->label('Name of Applicant');
                $fieldset->control('input:text', 'designation')
                    ->label('Designation');
                $fieldset->control('input:select', 'gender')
                    ->options(['male'=>'Male', 'female'=>'Female', 'other'=>'Other'])
                    ->value(null)
                    ->label('Gender');
                $fieldset->control('input:text', 'mail')
                    ->label('Contact E-Mail Address');
                $fieldset->control('input:text', 'phone')
                    ->label('Phone Number');
                $fieldset->control('input:text', 'address')
                    ->label('Franchisee&rsquo;s Office Address');
                $fieldset->control('input:text', 'passport_nid')
                    ->label('Passport or NID Number');
                $fieldset->control('input:text', 'photo')
                    ->label('Upload Recently Taken Portrait Photo');
                $fieldset->control('input:text', 'attachment')
                    ->label('Scan Copy of Passport Bio-Page or Both Sides of NID');

            });

        });
    }
}
