<?php

namespace Juzaweb\Contacts\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Contacts\Models\Contact;

class ContactDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name' => [
                'label' => trans('contacts::content.name'),
            ],
            'email' => [
                'label' => trans('contacts::content.email'),
            ],
            'phone' => [
                'label' => trans('contacts::content.phone'),
            ],
            'subject' => [
                'label' => trans('contacts::content.subject'),
            ],
            'created_at' => [
                'label' => trans('contacts::content.date'),
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                },
            ],
            'actions' => [
                'label' => trans('cms::app.actions'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return '<a href="contacts/' . $row->id . '/edit" class="btn btn-info px-2"><i class="fa fa-search"></i></a>';
                },
            ],
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = Contact::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', JW_SQL_LIKE, '%' . $keyword . '%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Contact::destroy($ids);
                break;
        }
    }
}
