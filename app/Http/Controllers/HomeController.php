<?php

namespace App\Http\Controllers;

use App\Models\BigRegion;
use App\Models\Citizen;
use App\Models\Distribution;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $statistics = [
            'total_citizens' => Citizen::count(),
            'total_distributed_aid' => Distribution::count(),
            'total_regions' => BigRegion::count(),
            'total_distributions' => Distribution::count(),
        ];

        $recentDistributions = Distribution::with(['source'])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($distribution) {
                return [
                    'name' => $distribution->name,
                    'category' => $distribution->category,
                    'status' => $distribution->status,
                    'progress' => $distribution->progress,
                    'source' => $distribution->source->name ?? 'غير محدد',
                    'date' => $distribution->created_at->format('Y-m-d'),
                ];
            });

        $bigRegions = BigRegion::withCount(['regions', 'citizens'])
            ->get();

        return view('home.index', compact('statistics', 'recentDistributions', 'bigRegions'));
    }
}
