<?php

namespace Juzaweb\Contacts\Http\Controllers;

use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Contacts\Http\Datatables\ContactDatatable;
use Juzaweb\Contacts\Models\Contact;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Validator;

class ContactsController extends BackendController
{

    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }
    protected $viewPrefix = 'contacts::backend';

    protected function getDataTable(...$params)
    {
        return new ContactDatatable();
    }
    protected function validator(array $attributes, ...$params)
    {
        $validator = Validator::make($attributes, [
            // Rules
        ]);

        return $validator;
    }

    protected function getModel(...$params)
    {
        return Contact::class;
    }
    protected function getTitle(...$params)
    {
        return trans('contacts::content.contact-us');
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        return $data;
    }


}
