<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectProgress;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();

        $totalProjects = Project::count();

        $activeProjects = Project::where('status', 'on_progress')->count();

        $completedProjects = Project::where('status', 'completed')->count();

        $totalContractValue = Project::sum('contract_value');

        $latestProgresses = ProjectProgress::with([
            'project',
            'user'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view(
            'owner.dashboard',
            compact(
                'totalClients',
                'totalProjects',
                'activeProjects',
                'completedProjects',
                'totalContractValue',
                'latestProgresses'
            )
        );
    }
}
