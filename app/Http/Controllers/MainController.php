<?php

namespace App\Http\Controllers;

use App\Repositories\MatchRepository;
use App\Repositories\ScoreRepository;
use App\Services\FixtureDraw\HomeAndAwayDraw;
use App\Services\Prediction\SimplePrediction;

class MainController extends Controller
{
    private $scoreRepository;
    private $matchRepository;

    public function __construct(ScoreRepository $scoreRepository, MatchRepository $matchRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->matchRepository    = $matchRepository;
        $this->handleRequirements();
    }

    public function handleRequirements()
    {
        //check if there is no scores yet, make it
        if (!$this->scoreRepository->checkScore()) {
            $this->scoreRepository->createScore();
        }
        //check if all matches are drawn
        if (!$this->matchRepository->checkIfFixturesDrawn()) {
            $this->makeFixtures();
        }
    }

    public function getStarting()
    {

        $matches     = $this->matchRepository->getFixture()->groupBy('week_id');
        $predictions = (new SimplePrediction($this->scoreRepository, $this->matchRepository))->getPrediction();

       
            return response()->json( [
                'weeks' => $this->matchRepository->getWeeks(),
                'matches' => $matches,
                'predictions' => $predictions
            ]);
    }

    public function makeFixtures()
    {
        $drawService = new HomeAndAwayDraw($this->matchRepository->getTeamsId());
        $this->matchRepository->createFixture($drawService->getFixturesPlan());
    }

    public function resetAll()
    {
        $this->matchRepository->truncateMatches();
        $this->scoreRepository->truncateScore();
        $this->makeFixtures();
        return response()->json(['status' => 'ok'], 200);
    }

    public function getScores()
    {
        return response()->json($this->scoreRepository->getAll());
    }

    public function getFixtures()
    {
        $weeks   = $this->matchRepository->getWeeks();
        $fixture = $this->matchRepository->getFixture()->groupBy('week_id');
        return response()->json(['weeks' => $weeks, 'items' => $fixture]);
    }


}
