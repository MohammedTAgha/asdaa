<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Citizen;
use App\Models\DistributionCitizen;
class DistributionCitizenController extends Controller
{
    public function index()
    {
        $distributionCitizens = DistributionCitizen::all();
        return view('distribution_citizens.index', compact('distributionCitizens'));
    }

    public function create()
    {
        $distributions = Distribution::all();
        $citizens = Citizen::all();
        return view('distribution_citizens.create', compact('distributions', 'citizens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distribution_id' => 'required|integer|exists:distributions,id',
            'citizen_id' => 'required|integer|exists:citizens,id',
            'quantity' => 'required|integer|min:1',
            'recipient' => 'required|string|max:255',
            'note' => 'nullable|string',
            'done' => 'required|boolean',
        ]);
        
        // DistributionCitizen::create($request->all());
        // logger()->info('Request data: ', $request->all());
        // $distribution = Distribution::find($request->distribution_id);
        // $citizen = Citizen::find($request->citizen_id);
        $d=new DistributionCitizen();
        $d->distribution_id=$request->input('distribution_id');
        $d->citizen_id=$request->input('citizen_id');
        $d->quantity=$request->input('quantity');
        $d->recipient=$request->input('recipient');
        $d->done=$request->input('done');
        $d->note=$request->input('note');
        DistributionCitizen::create($request->all());
       
       
        return redirect()->route('distribution_citizens.index')->with('success', 'DistributionCitizen created successfully');
    }

    public function show(DistributionCitizen $distributionCitizen)
    {
        return view('distribution_citizens.show', compact('distributionCitizen'));
    }

    public function edit(DistributionCitizen $distributionCitizen)
    {
        $distributions = Distribution::all();
        $citizens = Citizen::all();
        return view('distribution_citizens.edit', compact('distributionCitizen', 'distributions', 'citizens'));
    }

    public function update(Request $request, DistributionCitizen $distributionCitizen)
    {
        $request->validate([
            'distribution_id' => 'required|integer|exists:distributions,id',
            'citizen_id' => 'required|integer|exists:citizens,id',
            'quantity' => 'required|integer|min:1',
            'recipient' => 'required|string|max:255',
            'note' => 'nullable|string',
            'done' => 'required|boolean',
        ]);

        $distributionCitizen->update($request->all());

        return redirect()->route('distribution_citizens.index')->with('success', 'DistributionCitizen updated successfully');
    }

    public function destroy(DistributionCitizen $distributionCitizen)
    {
        $distributionCitizen->delete();

        return redirect()->route('distribution_citizens.index')->with('success', 'DistributionCitizen deleted successfully');
    }
}