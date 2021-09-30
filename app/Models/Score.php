<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'team_id',
        'points',
        'won',
        'lose',
        'draw',
        'played',
        'goal_drawn'
    ];


    public function won($goalDrawn)
    {
        //3 points if won
        $this->points     += 3;
        $this->played     += 1;
        $this->won        += 1;
        $this->goal_drawn += $goalDrawn;
    }

    public function lose($goalDrawn)
    {
        // 0 points if lose
        $this->played     += 1;
        $this->lose       += 1;
        $this->goal_drawn += -$goalDrawn;
      
    }


    public function draw()
    {
        // 1 point if draw
        $this->points += 1;
        $this->played += 1;
        $this->draw   += 1;
        
    }

}
