<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Logs::where('status', 'predicted')->orderByDesc('id');
        if ($request->has('start') && $request->filled('start')) {
            $query->where('updated_at', '>=', $request->start);
        }
        if ($request->has('end') && $request->filled('end')) {
            $query->where('updated_at', '<', $request->end);
        }
        $data = $query->paginate(10);
        return view('pages.history', compact(['data']));
    }

    public function results($id, Request $request)
    {
        Session::put('id', $id);

        $columns = [
            'error_level' => [
                'levels' => ['High', 'Medium', 'Low'],
                'name' => 'Error Level',
                'prefix' => true
            ],
            'security_vulnerability' => [
                'levels' => ['High', 'Medium', 'Low'],
                'name' => 'Security Vulnerability',
                'prefix' => true
            ],
            'error_impact_area' => [
                'levels' => ['Data Integrity', 'Performance', 'User Experience', 'Financial Systems', 'Deployment Infrastructure', 'Security'],
                'name' => 'Error Impact Area',
                'prefix' => true
            ],
            'error_priority' => [
                'levels' => ['Low Priority', 'Needs Improvement', 'Immediate Attention'],
                'name' => 'Error Priority',
                'prefix' => true
            ],
            'pipeline_stage' => [
                'levels' => ['Test', 'Deploy', 'Build'],
                'name' => 'Pipeline Stage Distribution',
                'prefix' => false
            ],
            'level' => [
                'levels' => ['ERROR', 'INFO', 'WARN'],
                'name' => 'Overall Distribution of Levels For Build Pipeline Stage',
                'prefix' => false
            ]
        ];

        $data = ErrorLog::where('logs_id', $id);


        foreach (array_keys($columns) as $filter) {
            if ($request->has($filter) && $request->filled($filter)) {
                $data->where($filter, $request->get($filter));
            }
        }

        $data = $data->paginate();

        return view('pages.results', compact(['data', 'id', 'columns']));
    }

    protected function optimizeForPrecentage($values)
    {

        $total = array_sum($values);

        foreach ($values as $key => $value) {
            $values[$key] = ($value / $total) * 100;
        }

        return $values;
    }
}
