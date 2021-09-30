<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MatchRepository;
use App\Repositories\ScoreRepository;
use App\Services\Simulator\MatchSimulator;

class SimulatorController extends Controller
{
    private $scoreRepository;
    private $matchRepository;

    public function __construct(ScoreRepository $scoreRepository, MatchRepository $matchRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->matchRepository    = $matchRepository;
    }

    public function playAllWeeks()
    {
        $matches = $this->matchRepository->getAllMatches();
        (new MatchSimulator($this->scoreRepository, $this->matchRepository))->bulkSimulate($matches);
        return response()->json(['status' => 'ok'], 200);
    }

    

    public function playWeekly($week)
    {
        $matches = $this->matchRepository->getMatchesFromWeek($week);
        (new MatchSimulator($this->scoreRepository, $this->matchRepository))->bulkSimulate($matches);
        $result = $this->matchRepository->getFixtureByWeekId($week);

        return response()->json([
            'status' => 'ok',
            'matches' => $result
        ], 201);
    }
}
