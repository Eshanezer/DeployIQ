<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Logs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class LogController extends Controller
{
    public function index()
    {
        $logsData = Logs::get();
        $data = array_filter(Storage::disk('error_logs')->files(), function ($item) {
            return strpos($item, '.txt');
        });
        krsort($data);
        return view('pages.logs', compact(['data', 'logsData']));
    }

    public function predict($filename)
    {
        if (!Storage::disk('error_logs')->exists($filename)) {
            abort(404);
        }

        Logs::create([
            'name' => $filename,
            'path' => Storage::disk('error_logs')->url($filename)
        ]);

        return Redirect::back();
    }

    public function getRecordForPrediction()
    {
        $file = Logs::where('status', 'submitted')->firstOrFail();
        $file->update([
            'status' => 'approved'
        ]);
        return [
            'path' => $file->path,
            'id' => $file->id
        ];
    }

    public function submitPrediction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:logs,id',
                'prediction' => 'required|mimes:csv,txt|max:10240'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->first(),
                ], 422);
            }

            $file = Logs::where('id', $request->id)->firstOrFail();

            if ($request->hasFile('prediction') && $request->file('prediction')->isValid()) {

                $fileName = $file->name . '.csv';

                Storage::disk('error_logs')->putFileAs('csv', $request->file('prediction'), $fileName);

                $absolutePath = Storage::disk('error_logs')->url('csv/' . $fileName);

                $file->update([
                    'status' => 'predicted',
                    'predicted_path' => $absolutePath
                ]);

                $csv = Reader::createFromPath(storage_path('logs/csv/' . $fileName), 'r');
                $csv->setHeaderOffset(0);

                foreach ($csv as $record) {
                    $timestamp = \DateTime::createFromFormat('m/d/Y H:i', $record['Timestamp']);
                    if (!$timestamp) {
                        continue;
                    }

                    ErrorLog::create([
                        'logs_id' => $file->id,
                        'timestamp' => $timestamp,
                        'level' => $record['Level'],
                        'event_id' => $record['EventId'],
                        'message' => $record['Message'],
                        'event_template' => $record['EventTemplate'],
                        'suggestion' => $record['Suggestion'],
                        'pipeline_stage' => $record['PipelineStage'],
                        'technology_stack' => $record['TechnologyStack'],
                        'triggered_by' => $record['TriggeredBy'],
                        'error_level' => $record['ErrorLevel'],
                        'security_vulnerability' => $record['SecurityVulnerability'],
                        'error_impact_area' => $record['ErrorImpactArea'],
                        'error_priority' => $record['ErrorPriority'],
                    ]);
                }

                return response()->json([
                    'status' => 'OK',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
            ], 422);
        }
    }

    public function moreinfo($fileName)
    {
        $file = Logs::where('name', $fileName)->where('status', 'predicted')->firstOrFail();

        Session::put('filename', $fileName);

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

        $charts = [];

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



        return view('pages.logs-moreinfo', compact(['file', 'charts']));
    }

    protected function optimizeForPrecentage($values){

        $total = array_sum($values);

        foreach ($values as $key => $value) {
            $values[$key] = ($value / $total) * 100;
        }

        return $values;
    }
}
