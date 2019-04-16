<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ContactRequest as StoreRequest;
use App\Http\Requests\ContactRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ContactCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Contact');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contact');
        $this->crud->setEntityNameStrings('contact', 'contacts');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Họ Tên'
            ],
            [
                'name' => 'phone',
                'label' => 'Số ĐT'
            ],
            [
                'name' => 'content',
                'label' => 'Ghi chú'
            ],
            [
                'label' => 'Admin xử lý',
                'type' => 'select',
                'name' => 'user_id',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => "App\Models\BackpackUser",
                'searchLogic' => false,
            ],

            [
                'label' => 'Trạng thái',
                'name' => 'status',
                'type' => 'select_from_array',
                'options' => [
                    0 => 'Vừa nhận',
                    1 => 'Đang xử lý',
                    2 => 'Đã xử lý'
                ]
            ]

        ]);

        $this->crud->addFields([
            [
                'label' => 'Trạng thái',
                'name' => 'status',
                'type' => 'select_from_array',
                'options' => [
                    0 => 'Vừa nhận',
                    1 => 'Đang xử lý',
                    2 => 'Đã xử lý'
                ]
            ],
            [
                'name' => 'content',
                'label' => 'Ghi chú',
                'type' => 'textarea'
            ]
        ]);
        $this->crud->orderBy('updated_at', 'desc');
        $this->crud->denyAccess('create');
        $this->crud->denyAccess('delete');

        // add asterisk for fields that are required in ContactRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);

        if (!$this->crud->entry->user_id) {
            $this->crud->entry->user_id = backpack_user()->id;
            $this->crud->entry->save();
        }
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
