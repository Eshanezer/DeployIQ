<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Logs;
use App\Models\MainDevice;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Water;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $file = Logs::where('status', 'predicted')->latest()->first();
        
        $charts = [];

        if ($file) {
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

            $colors = [
                '#FF6384', // Red (ERROR)
                '#36A2EB', // Blue (WARN)
                '#FFCE56', // Yellow (INFO)
                '#4BC0C0', // Teal
                '#9966FF', // Purple
                '#FF9F40', // Orange
            ];


            foreach ($columns as $key => $value) {

                $values = [];

                foreach ($value['levels'] as $key1 => $value1) {
                    $values[] = $file->errorLogs->where($key, $value1)->count();
                }

                $values = $this->optimizeForPrecentage($values);

                $data = [
                    'id' => $key,
                    'name' => $value['name'],
                    'labels' => $value['levels'],
                    'colors' => $colors,
                    'values' => $values
                ];

                if (isset($value['prefix']) && $value['prefix']) {
                    $data['name'] = $data['name'] . ' Prediction Distribution';
                }

                $charts[] = $data;
            }
        }

        $logsData = Logs::get();
        $data = array_filter(Storage::disk('error_logs')->files(), function ($item) {
            return strpos($item, '.log');
        });
        krsort($data);

        $logReportCount = count($data);
        $submittedReportCount = $logsData->where('status', 'submitted')->count();
        $approvedReportCount = $logsData->where('status', 'approved')->count();
        $predictedReportCount = $logsData->where('status', 'predicted')->count();
        $predictedReportCountForThisMonth = Logs::whereMonth('created_at', Carbon::now()->month)->where('status', 'predicted')->count();


        return view('pages.home', compact([
            'logReportCount',
            'submittedReportCount',
            'approvedReportCount',
            'predictedReportCount',
            'predictedReportCountForThisMonth',
            'logsData',
            'data',
            'charts'
        ]));
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
