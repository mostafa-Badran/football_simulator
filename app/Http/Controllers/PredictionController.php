<?php

namespace App\Http\Controllers;

use App\Repositories\MatchRepository;
use App\Repositories\ScoreRepository;
use App\Services\Prediction\SimplePrediction;

class PredictionController extends Controller
{

    private $scoreRepository;
    private $matchRepository;

    public function __construct(ScoreRepository $scoreRepository, MatchRepository $matchRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->matchRepository    = $matchRepository;
    }

    public function getPrediction()
    {
        $predictions = (new SimplePrediction($this->scoreRepository, $this->matchRepository))->getPrediction();
        return response()->json([
            'status' => 'ok',
            'predictions' => $predictions
        ], 200);
    }
}
