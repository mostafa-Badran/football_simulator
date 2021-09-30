<?php

namespace App\Services\Simulator;

use App\Repositories\MatchRepository;
use App\Repositories\ScoreRepository;

class MatchSimulator implements ResultSimulatorInterface
{

    protected $scoreRepository;
    protected $matchRepository;

    public function __construct(ScoreRepository $scoreRepository, MatchRepository $matchRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->matchRepository = $matchRepository;
    }

    public function simulate($match)
    { 
        $home = $this->scoreRepository->getScoreByTeamId($match->home_team); 
        $away = $this->scoreRepository->getScoreByTeamId($match->away_team);
        $homeScore = $this->generateScore(true, $home->id);
        $awayScore = $this->generateScore(false, $away->id);

        $this->updateMatchScore($homeScore, $awayScore, $home, $away);
        return $this->matchRepository->resultSaver($match, $homeScore, $awayScore);

    }

    public function bulkSimulate($matches)
    {
        foreach ($matches as $match) {
            $this->simulate($match);
        }
    }

    public function updateMatchScore($homeScore, $awayScore, $home, $away)
    {
        $this->matchRepository->updateMatchScore($homeScore, $awayScore, $home, $away);
    }


    public function generateScore(bool $is_home, int $teamRank)
    {
        
        return $is_home ? rand(0, 10) : rand(0, 10 - $teamRank);
    }

}
