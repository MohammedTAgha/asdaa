<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs=ActivityLog::all();

        return view('logs.index',compact('logs'));
    }

    public function getData(Request $request)
    {
        $query = ActivityLog::with('user')->select('logs.*');

        return DataTables::of($query)
            ->addColumn('user_name', function ($log) {
                return $log->user ? $log->user->name : 'System';
            })
            ->addColumn('created_at_formatted', function ($log) {
                return $log->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('details', function ($log) {
                $details = '';
                if ($log->old_values) {
                    $details .= '<strong>Old Values:</strong><br>' . json_encode($log->old_values, JSON_PRETTY_PRINT) . '<br>';
                }
                if ($log->new_values) {
                    $details .= '<strong>New Values:</strong><br>' . json_encode($log->new_values, JSON_PRETTY_PRINT);
                }
                return $details;
            })
            ->rawColumns(['details'])
            ->make(true);
    }
}
