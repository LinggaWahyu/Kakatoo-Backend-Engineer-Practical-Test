<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::get();

        foreach ($skills as $skill) {
            $skill['skill_name'] = $skill->name;
            unset($skill->name);
            unset($skill->created_at);
            unset($skill->updated_at);
        }

        return response($skills);
    }
}
