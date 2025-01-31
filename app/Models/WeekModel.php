<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekModel extends Model
{
    use HasFactory;

    protected $table = 'week';

    static public function getRecord()
    {
        return WeekModel::whereNotIn('name', ['Friday'])
                        ->orderByRaw("CASE 
                            WHEN name = 'Saturday' THEN 1 
                            WHEN name = 'Sunday' THEN 2
                            WHEN name = 'Monday' THEN 3
                            WHEN name = 'Tuesday' THEN 4
                            WHEN name = 'Wednesday' THEN 5
                            WHEN name = 'Thursday' THEN 6
                            END")
                        ->get();
    }

    static public function getWeekUsingName($weekname)
    {
        return WeekModel::where('name','=',$weekname)->first();
    }

}
