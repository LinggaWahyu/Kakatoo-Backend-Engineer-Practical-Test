<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index($skill_id)
    {
        $activities = Activity::with('skill')->where('skill_id', $skill_id)->orderBy('startdate')->get();

        if (count($activities) === 0) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        $output = array();
        foreach ($activities as $key=> $activity) {
            $output[$key]['skill_id'] = $activity->skill->id;
            $output[$key]['skill_name'] = $activity->skill->name;
            $output[$key]['title'] = $activity->title;
            $output[$key]['description'] = $activity->description;
            $output[$key]['startdate'] = date_format($activity->startdate, "d F Y");
            $output[$key]['enddate'] = date_format($activity->enddate, "d F Y");
            $output[$key]['participans'] = array();

            foreach ($activity->participans as $key_participan => $participan) {
                $output[$key]['participans'][$key_participan]['id'] = $participan;

                $user = User::with('profile', 'skill')->find($participan);

                $output[$key]['participans'][$key_participan]['name'] = $user->name;
                $output[$key]['participans'][$key_participan]['profile'] = $user->profile->name;
                $output[$key]['participans'][$key_participan]['skill'] = $user->skill->name;
            }
        }

        return response($output);
    }

    public function store(Request $request)
    {
        $rules = [
            'skill_id' => 'required|integer|exists:App\Models\Skill,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after:startdate',
            'participans' => 'required|array'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        foreach ($data['participans'] as $participan) {
            $user = User::find($participan);

            if (!$user) {
                return response()->json([
                    'message' => 'Data cannot be processed'
                ], 422);
            } else if ($user->skill_id != $data['skill_id']) {
                return response()->json([
                    'message' => 'Data cannot be processed'
                ], 422);
            }
        }

        Activity::create($data);

        return response()->json([
            'message' => 'create success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        $rules = [
            'skill_id' => 'integer|exists:App\Models\Skill,id',
            'title' => 'string',
            'description' => 'string',
            'startdate' => 'date',
            'enddate' => 'date|after:startdate',
            'participans' => 'array'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        if ($request->participans) {
            foreach ($data['participans'] as $participan) {
                $user = User::find($participan);

                if (!$user) {
                    return response()->json([
                        'message' => 'Data cannot be processed'
                    ], 422);
                } else if ($user->skill_id != $data['skill_id']) {
                    return response()->json([
                        'message' => 'Data cannot be processed'
                    ], 422);
                }
            }
        }

        $activity->fill($data);
        $activity->save();

        return response()->json([
            'message' => 'update success'
        ]);
    }

    public function destroy($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        $activity->delete();

        return response()->json([
            'message' => 'update success'
        ]);
    }
}
