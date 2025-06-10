<?php

namespace App\Http\Controllers;

use App\Models\TimeLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function generate(Request $request)
    {

        $query = TimeLogs::join('projects', 'time_logs.project_id', '=', 'projects.id')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->when($request->client_id, fn($q, $id) => $q->where('projects.client_id', $id))
            ->when($request->project_id, fn($q, $id) => $q->where('time_logs.project_id', $id))
            ->when($request->from, fn($q, $date) => $q->where('time_logs.created_at', '>=', $date))
            ->when($request->to, fn($q, $date) => $q->where('time_logs.created_at', '<=', $date));

        // results
        $report = [
            'total_hours' => $query->sum('hour'),

            'per_project' => $query->groupBy('time_logs.project_id')
                ->selectRaw('time_logs.project_id, SUM(time_logs.hour) as total')
                ->get(),

            'per_day' => $query->groupBy('time_logs.created_at')
                ->selectRaw('DATE(time_logs.created_at) as date, SUM(time_logs.hour) as total')
                ->get(),

            'per_client' => $query->groupBy('projects.client_id')
                ->selectRaw('projects.client_id, SUM(time_logs.hour) as total')
                ->get(),
        ];

        return response()->json($report);
    }


    public function exportPDF(Request $request)
    {
        $logs = TimeLogs::with(['project', 'client'])
            ->filter($request->all())
            ->get();

        $pdf = Pdf::loadView('reports.time_logs', compact('logs'));
        return $pdf->download('time-logs-report.pdf');
    }
}