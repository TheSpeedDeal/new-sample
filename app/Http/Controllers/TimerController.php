<?php

namespace App\Http\Controllers;

use App\Models\CustomTimer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class TimerController extends Controller
{
    //join/{id}/statusTimer
    public function statusTimer(Request $request){
        $timer = CustomTimer::select()->where('roomName', $request->roomName)->first();
        $timer->status = $request->action;
        if($timer->endTime === null){
            $timer->endTime = Carbon::now('Asia/Manila')->addMinutes($request->time);
        }
        //$timer->endTime = null;
        $timer->save();
    }
    ///join/{id}/getSyncTime
    public function getSyncTimer($rName) {
        $timer = CustomTimer::where('roomName', $rName)->first();
        return $timer->endTime;
    }

    ///join/{id}/updateTimer
    public function syncTimer(Request $request){
        $timer = CustomTimer::select()->where('roomName', $request->roomName)->first();
        //workTime, shortBreak, longBreak
        if($request->mode == 'shortBreak'){
            $timer->update([
                'mode' => $request->mode,
                'endTime' => Carbon::now('Asia/Manila')->addMinutes($timer->breakTime),
            ]); 
        }
        else if($request->mode == 'longBreak'){
            $timer->update([
                'mode' => $request->mode,
                'endTime' => Carbon::now('Asia/Manila')->addMinutes($timer->longBreakTime),
            ]); 
        }
        else if($request->mode == 'workTime'){
            $timer->update([
                'mode' => $request->mode,
                'endTime' => Carbon::now('Asia/Manila')->addMinutes($timer->workTime),
            ]); 
        }
        $timer->save();
    }
}

