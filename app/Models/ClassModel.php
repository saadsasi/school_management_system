<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $fillable = ['name', 'grade_level', 'amount', 'status', 'created_by'];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', 'class.created_by');

        if(!empty(Request::get('name')))
        {
            $return = $return->where('class.name', 'like', '%'.Request::get('name').'%');
        }

        if(!empty(Request::get('grade_level')))
        {
            $return = $return->where('class.grade_level', Request::get('grade_level'));
        }

        if(!empty(Request::get('date')))
        {
            $return = $return->whereDate('class.created_at','=', Request::get('date'));
        }

        $return = $return->where('class.is_delete', '=', 0)
                ->orderBy('class.id', 'desc')
                ->paginate(20);

        return $return;
    }
    static public function getClassesByGradeLevel($grade_level)
    {
        return self::where('grade_level', $grade_level)
                  ->where('is_delete', 0)
                  ->where('status', 0)
                  ->get();
    }

    static public function getClass()
    {
        $return = ClassModel::select('class.*')
                    ->join('users', 'users.id', 'class.created_by')
                    ->where('class.is_delete', '=', 0)
                    ->where('class.status', '=', 0)
                    ->orderBy('class.name', 'asc')
                    ->get();

        return $return;
    }

    static public function getTotalClass()
    {
        $return = ClassModel::select('class.id')
                    ->join('users', 'users.id', 'class.created_by')
                    ->where('class.is_delete', '=', 0)
                    ->where('class.status', '=', 0)
                    ->count();

        return $return;
    }



}
