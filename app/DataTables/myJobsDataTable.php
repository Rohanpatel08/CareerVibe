<?php

namespace App\DataTables;

use App\Models\CareerJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class myJobsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = (new EloquentDataTable($query))
            ->addColumn('Title', function ($row) {
                $jobType = $row->jobType ? $row->jobType->job_type : 'N/A';

                return '<div class="job-name fw-500">'.e($row->title).'</div>'.
                    '<div class="info1">'.e($jobType).' . '.e($row->location).'</div>';
            })
            ->addColumn('Job Created', function ($row) {
                return Carbon::parse($row->created_at)->format('d M, Y');
            })
            ->addColumn('Applicants', function ($row) {
                return '0 Applications';
            })
            ->addColumn('Status', function ($row) {
                return '<div class="job-status text-capitalize">'.($row->status == 1 ? 'active' : 'expired').'</div>';
            })
            ->addColumn('Action', function ($row) {
                $viewUrl = route('job.details', base64_encode($row->id));
                $editUrl = route('job.edit', base64_encode($row->id));
                $deleteFunc = "deleteJob('".base64_encode($row->id)."')";

                return '<div class="action-dots float-end">'
                    .'<a href="#" data-bs-toggle="dropdown" aria-expanded="false">'
                    .'<i class="fa fa-ellipsis-v" aria-hidden="true"></i>'
                    .'</a>'
                    .'<ul class="dropdown-menu dropdown-menu-end">'
                    .'<li><a class="dropdown-item" href="'.$viewUrl.'">'
                    .'<i class="fa fa-eye" aria-hidden="true"></i> View</a></li>'
                    .'<li><a class="dropdown-item" href="'.$editUrl.'">'
                    .'<i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>'
                    .'<li><a class="dropdown-item" href="#" onclick="'.$deleteFunc.'">'
                    .'<i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>'
                    .'</ul>'
                    .'</div>';
            })
            ->rawColumns(['Title', 'Status', 'Action'])
            ->setRowId('id');

        $dt->filterColumn('Title', function ($query, $keyword) {
            $like = "%{$keyword}%";
            $query->where(function ($q) use ($like) {
                $q->where('title', 'like', $like)
                    ->orWhere('location', 'like', $like)
                    ->orWhereHas('jobType', function ($q2) use ($like) {
                        $q2->where('job_type', 'like', $like);
                    });
            });
        });

        return $dt;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CareerJob $model): QueryBuilder
    {
        // Important: call newQuery() first, then add with()/where() so they are applied
        return $model->newQuery()->with('jobType')->where('user_id', Auth::id())->orderBy('created_at', 'DESC');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('myjobs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->lengthMenu([[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]])
            ->orderBy(1)
            ->parameters([
                // Bootstrap layout
                'dom' => "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-end'f>>".
                         't'.
                         "<'row mt-3'<'col-sm-6'i><'col-sm-6'p>>",

                // Remove extra spacing in pagination (Bootstrap-compatible)
                'pagingType' => 'simple_numbers',

                // Add Bootstrap classes to pagination buttons (fixes big spacing)
                'language' => [
                    'paginate' => [
                        'previous' => '&laquo;',
                        'next' => '&raquo;',
                    ],
                ],

                // Automatically trim whitespace inside pagination buttons
                'drawCallback' => "function() {
                    $('.dataTables_paginate .pagination').addClass('mb-0');
                    $('.dataTables_length select').css('width', '60px');   // length select width fix

                    // Remove extra padding from li.page-item
                    $('#myjobs-table_paginate .page-item').css('padding', '0');

                    // Optional: also remove padding from the link for cleaner look
                    $('#myjobs-table_paginate .page-item .page-link').css('padding', '6px 12px');

                    $('div.dataTables_wrapper div.dataTables_length select').css('height', '40px');
                    $('div.dataTables_wrapper div.dataTables_filter input').css('height', '35px');
                }",
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // computed for columns we render manually
            Column::make('Title')->searchable(true)->orderable(true)->addClass('text-center'),
            Column::make('Job Created')->searchable(false)->orderable(false)->addClass('text-center'),
            Column::make('Applicants')->searchable(false)->orderable(false)->addClass('text-center'),
            Column::make('Status')->searchable(false)->orderable(false)->addClass('text-center'),
            Column::computed('Action')->addClass('text-center')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'myJobs_'.date('YmdHis');
    }
}
