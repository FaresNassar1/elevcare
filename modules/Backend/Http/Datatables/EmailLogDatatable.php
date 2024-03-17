<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Jobs\SendEmailJob;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\CMS\Support\SendEmail;

class EmailLogDatatable extends DataTable
{
    protected string $sortName = 'updated_at';

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'subject' => [
                'label' => trans_cms('cms::app.subject'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return $row->getSubject();
                }
            ],
            'content' => [
                'label' => trans_cms('cms::app.content'),
                'formatter' => function ($value, $row, $index) {
                    return $row->getBody();
                }
            ],
            'status' => [
                'label' => trans_cms('cms::app.status'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    return match ($value) {
                        EmailList::STATUS_SUCCESS => '<span class="text-success">' . trans_cms('cms::app.sended') . '</span>',
                        EmailList::STATUS_PENDING => '<span class="text-warning">' . trans_cms('cms::app.pending') . '</span>',
                        EmailList::STATUS_CANCEL => '<span class="text-success">' . trans_cms('cms::app.cancel') . '</span>',
                        default => '<span class="text-danger">' . trans_cms('cms::app.error') . '</span>',
                    };
                }
            ],
            'updated_at' => [
                'label' => trans_cms('cms::app.updated_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->updated_at);
                },
            ],
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|Builder
     */
    public function query($data)
    {
        $query = EmailList::with(['template']);

        if ($search = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($search) {
                    $q->where('subject', JW_SQL_LIKE, '%' . $search . '%');
                    $q->orWhere('content', JW_SQL_LIKE, '%' . $search . '%');
                }
            );
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function actions(): array
    {
        return [
            'delete' => trans_cms('cms::app.delete'),
            'resend' => trans_cms('cms::app.resend'),
            'cancel' => trans_cms('cms::app.cancel'),
        ];
    }

    public function bulkActions($action, $ids)
    {

        switch ($action) {
            case 'delete':
                global $jw_user;
                if (!$jw_user->can('email_logs.delete')) {
                    abort(403);
                }
                EmailList::destroy($ids);
                break;
            case 'resend':
                global $jw_user;
                if (!$jw_user->can('email_logs.resend')) {
                    abort(403);
                }
                $method = config('juzaweb.email.method');
                $status = EmailList::STATUS_PENDING;

                $emailLists = EmailList::whereIn('id', $ids)
                    ->whereIn(
                        'status',
                        [
                            EmailList::STATUS_PENDING,
                            EmailList::STATUS_ERROR
                        ]
                    )
                    ->get();

                foreach ($emailLists as $emailList) {
                    switch ($method) {
                        case 'sync':
                            (new SendEmail($emailList))->send();
                            break;
                        case 'queue':
                            SendEmailJob::dispatch($emailList);
                            break;
                    }

                    $emailList->update(
                        [
                            'status' => $status
                        ]
                    );
                }

                break;
            case 'cancel':
                global $jw_user;
                if (!$jw_user->can('email_logs.cancel')) {
                    abort(403);
                }
                $status = $action;
                EmailList::whereIn('id', $ids)
                    ->whereIn(
                        'status',
                        [
                            EmailList::STATUS_PENDING,
                            EmailList::STATUS_ERROR
                        ]
                    )
                    ->update(
                        [
                            'status' => $status
                        ]
                    );
        }
    }
}
