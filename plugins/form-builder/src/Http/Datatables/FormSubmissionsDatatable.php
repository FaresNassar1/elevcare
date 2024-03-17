<?php

namespace Progmix\FormBuilder\Http\Datatables;

use Progmix\FormBuilder\Models\FormSubmission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;

class FormSubmissionsDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name'    => [
                'label'     => 'name',
                'width'     => '15%',
                'align'     => 'start',
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
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
        $query = FormSubmission::query()->with('form');

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->whereHas('form', function (Builder $q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }

        if ($keyword = Arr::get($data, 'forms')) {
            $query->whereHas('form', function (Builder $q) use ($keyword) {
                $q->where('id', $keyword);
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                FormSubmission::destroy($ids);
                break;
        }
    }

    public function rowActionsFormatter($value, $row, $index): string
    {
        $title_table = $row->form?->name;

        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $title_table,
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => route('form.view.disabled', $row->id),
                'editUrlShow' => false

            ]
        )
            ->render();
    }


    public function rowAction($row): array
    {
        $data = parent::rowAction($row);
        $data['view'] = [
            'label' => trans_cms('cms::app.view'),
            'url' => route('form.view.disabled', $row->id),
            'target' => '_blank',
        ];
        return $data;
    }

    public function searchFields(): array
    {
        $data = [
            'keyword' => [
                'type' => 'text',
                'label' => trans_cms('cms::app.keyword'),
                'placeholder' => trans_cms('cms::app.keyword'),
            ],
            'forms' => [
                'type' => 'select',
                'width' => '100px',
                'label' => trans_cms('cms::app.forms'),
                'options' => $forms = $this->makeModel()->get()->pluck('name', 'id')->toArray(),
            ],
        ];
        return $data;
    }

    protected function makeModel()
    {
        return app('Progmix\FormBuilder\Models\Form');
    }
}
