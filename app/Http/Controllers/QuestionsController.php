<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function getCommonQuestions()
    {
        return response()->json([
            'status' => true,
            'questions' => Question::all(),
        ]);
    }
}
