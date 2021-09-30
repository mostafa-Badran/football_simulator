<?php

namespace App\Repositories;

use App\Models\Score;
use App\Models\Team;

class ScoreRepository
{

    private $score;
    private $team;

    public function __construct(Score $score, Team $team)
    {
        $this->score = $score;
        $this->team = $team;
    }

    public function checkScore()
    {
        $result = $this->score->get();
        return $result->isEmpty() ? false : true;
    }

    public function createScore()
    {
        $result = $this->score->get();
        if (!$result->isEmpty()) {
            return;
        }
        foreach ($this->getTeams() as $value) {
            $data = [
                'team_id'    => $value,
                'played'     => 0,
                'won'        => 0,
                'lose'       => 0,
                'draw'       => 0,
                'goal_drawn' => 0,
                'points'     => 0
            ];
            $this->score->create($data);
        }

    }

    public function getTeams()
    {
        return $this->team->pluck('id');
    }

    public function getAll()
    {
        return $this->team->leftJoin('scores', 'teams.id', '=', 'scores.team_id')
            ->orderBy('scores.points', 'DESC')
            ->orderBy('scores.goal_drawn', 'DESC')
            ->orderBy('scores.won', 'DESC')
            ->get();
    }

    public function getScoreByTeamId($team_id)
    {
        return $this->score->where('team_id', $team_id)->first();
    }

    public function truncateScore()
    {
        $this->score->truncate();
    }

    public function checkScoreStatus()
    {
        return $this->score->select('played')->first();
    }
    public function checkStandingStatus()
    {
        return $this->standing->select('played')->first();
    }

}
