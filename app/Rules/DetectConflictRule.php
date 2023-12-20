<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Event;

class DetectConflictRule implements Rule
{

    private  $eventDateFrom, $eventDateTo, $startTime, $endTime, $data;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        $eventDateFrom,
        $eventDateTo,
        $startTime,
        $endTime,
        $id
    )
    {
        //
        $this->eventDateFrom = $eventDateFrom;
        $this->eventDateTo = $eventDateTo;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $sTime = $this->startTime;
        $eTime = $this->endTime;
        $eventDateFrom = $this->eventDateFrom;
        $eventDateTo = $this->eventDateTo;

        //separate logic for edit and create
        if($this->id > 0){
            $data = Event::where(function($query) use ($sTime, $eTime, $eventDateFrom, $eventDateTo){
                $query->whereBetween('event_time_from', [$sTime, $eTime])
                    ->orWhereBetween('event_time_to', [$sTime, $eTime]);
            })
            ->where(function($query) use ($eventDateFrom, $eventDateTo){
                $query->whereBetween('event_date_from', [$eventDateFrom, $eventDateTo])
                    ->orWhereBetween('event_time_to', [$eventDateFrom, $eventDateTo]);
            })
            //->where('event_date', $eventDate)
            ->where('event_id','!=', $this->id)
            ->where('event_venue_id', $value);
        }else{
            $data = Event::where(function($query) use ($sTime, $eTime){
                $query->whereBetween('event_time_from', [$sTime, $eTime])
                    ->orWhereBetween('event_time_to', [$sTime, $eTime]);
            })
            ->where(function($query) use ($eventDateFrom, $eventDateTo){
                $query->whereBetween('event_date_from', [$eventDateFrom, $eventDateTo])
                    ->orWhereBetween('event_time_to', [$eventDateFrom, $eventDateTo]);
            })
            ->where('event_venue_id', $value);
        }


        $exist = $data->exists();
        $this->data = $data->first();


        if($exist){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  [
            'msg' => 'Event schedule already exist.',
            'data' => $this->data
        ];;
    }
}
