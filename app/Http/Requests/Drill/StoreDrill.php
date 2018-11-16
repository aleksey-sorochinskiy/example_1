<?php

namespace App\Http\Requests\Drill;

use App\Drill;
use App\Http\Requests\BaseRequest;

class StoreDrill extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                              => 'required|max:50',
            'description'                       => 'nullable|max:100|string',
            'coaching_points'                   => 'nullable|max:50|string',
            'hr_intensity'                      => 'required|integer|between:1,4',
            'is_interval'                       => 'required|boolean',
            'players_number'                    => 'integer|min:1',
            'set_of_exercise_id'                => 'required|exists:set_of_exercises,id',
            'drill_duration'                    => ['required' ,'string', 'regex:/[0-9][0-9]:[0-5][0-9]/'],
            'rest_duration'                     => ['string', 'regex:/[0-9][0-9]:[0-5][0-9]/'],
            'rest_type'                         => 'required|in:'.implode( ',',Drill::REST_TYPES),
            'rest_description'                  => 'nullable|max:100|string',
            'reps_number'                       => 'required_if:series_type,'.Drill::SERIES_TYPE_REGULAR,
            'series_type'                       => 'required|in:'.implode( ',',Drill::SERIES_TYPES),
            'series_number'                     => 'required|integer',
            'series_rest_duration'              => ['required' ,'string', 'regex:/[0-9][0-9]:[0-5][0-9]/'],
            'series_rest_description'           => 'nullable|string|max:100',
            'image'                             => 'string',
            'image_file'                        => 'image|mimes:jpeg,gif,png|max:6144',
            'video'                             => 'string',
            'video_file'                        => 'file|mimes:mpeg,mpg,mp4,flv,m3u8,ts,3gp,mov,avi,wmv,ogg,qt,ogv|max:10000',
            'series'                            => '',
            'series.*.reps_number'              => 'required|integer',
            'series.*.reps_duration'            => ['string', 'regex:/[0-9][0-9]:[0-5][0-9]/'],
            'series.*.reps_rest_duration'       => ['required' ,'string', 'regex:/[0-9][0-9]:[0-5][0-9]/'],
            'series.*.reps_rest_type'           => 'required|in:'.implode(',', Drill::REST_TYPES),
            'series.*.reps_rest_description'    => 'nullable|string|max:100'
        ];
    }

    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                              => 'Drill name',
            'description'                       => 'Drill description',
            'coaching_points'                   => 'Coaching points',
            'hr_intensity'                      => 'HR intensity',
            'drill_duration'                    => 'Drill duration',
            'rest_type'                         => 'Rest type',
            'rest_description'                  => 'Rest description',
            'series_type'                       => 'Series type',
            'series_number'                     => 'Series number',
            'series_rest_description'           => 'Rest description',
            'reps_number'                       => 'Reps number',
            'reps_duration'                     => 'Reps duration',
            'reps_description'                  => 'Reps Rest Description',
            'series.*.reps_number'              => 'Reps number',
            'series.*.reps_rest_duration'       => 'Rest duration ',
            'series.*.reps_rest_type'           => 'Reps rest type',
            'series.*.reps_rest_description'    => 'Reps Rest Description'
        ];
    }
}
