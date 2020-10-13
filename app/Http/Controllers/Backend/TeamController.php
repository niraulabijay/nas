<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Repositories\Contracts\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
	private $teamRepository;

	public function __construct(TeamRepository $teamRepository)
	{
		$this->teamRepository = $teamRepository;
	}

    public function index()
    {
    	return view('admin.team.index');
    }

    public function create()
    {
    	return view('admin.team.create');
    }

    public function store(TeamRequest $request)
    {
    	$this->teamRepository->store($request->all());
    	return response()->json('Team member successfully added!');
    }

    public function edit($id)
    {
    	$team = $this->teamRepository->find($id);
    	return view('admin.team.edit', compact('team'));
    }

    public function update($id, TeamRequest $request)
    {
    	$this->teamRepository->updateTeam($id, $request->all());
    	return redirect()->back()->with('success', 'Team member successfully updated!');
    }

    public function delete($id)
    {
    	$this->teamRepository->deleteTeam($id);
    	return response()->json('Team member successfully deleted!');
    }

    public function getTeamJson()
    {
    	$teams = $this->teamRepository->all();
    	foreach ($teams as $team) {
            $image = null !== $team->getImage()? $team->getImage()->smallUrl: $team->getDefaultImage()->smallUrl;
            $team->image = $image;
        } 
    	return datatables($teams)->toJson();
    }
}
