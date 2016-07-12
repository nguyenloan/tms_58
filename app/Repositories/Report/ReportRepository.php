<?php

namespace App\Repositories\Report;

use App\Repositories\BaseRepository;
use App\Models\DailyReport;
use App\Models\User;
use Exception;
use Auth;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    public function __construct(DailyReport $report)
    {
        $this->model = $report;
    }

    public function listReport()
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.base_repository.limit');
        $order = isset($options['order']) ? $options['order'] : config('common.base_repository.order_by');
        $filter = isset($options['filter']) ? $options['filter'] : config('common.base_repository.filter');
        $report = $this->model->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);

        return $report;
    }
}
