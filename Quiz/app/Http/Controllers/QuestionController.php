<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource for a specific quiz.
     */
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId); // Ensure quiz exists
        $questions = Question::where('quiz_id', $quizId)->get(); // Fetch questions for the quiz
        return view('questions.index', compact('quiz', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId); // Ensure quiz exists
        return view('questions.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:255',
            'options' => 'required|array',
            'correct_option' => 'required|integer', // Ensure correct option is valid
        ]);

        // Store the question
        $question = new Question();
        $question->quiz_id = $request->quiz_id;
        $question->question_text = $request->question_text;
        $question->options = json_encode($request->options); // Convert options array to JSON
        $question->correct_option = $request->correct_option;
        $question->is_submitted = 0; // Default value for is_submitted
        $question->save();

        return redirect()->route('questions.index', $question->quiz_id)
            ->with('success', 'Question added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $question->options = json_decode($question->options, true); // Decode JSON to array
        $quiz = Quiz::findOrFail($question->quiz_id);
        return view('questions.edit', compact('question', 'quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:255',
            'options' => 'required|array',
            'correct_option' => 'required|integer',
        ]);

        // Update the question
        $question = Question::findOrFail($id);
        $question->question_text = $request->question_text;
        $question->quiz_id = $request->quiz_id;
        $question->options = json_encode($request->options); // Convert options array to JSON
        $question->correct_option = $request->correct_option;
        $question->save();

        return redirect()->route('questions.index', $question->quiz_id)
            ->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id; // Save quiz ID to redirect later
        $question->delete();

        return redirect()->route('questions.index', $quizId)
            ->with('success', 'Question deleted successfully!');
    }

    public function submitQuestions($quizId)
    {
        // Get all questions for the quiz
        $questions = Question::where('quiz_id', $quizId)->get();

        // Mark all questions as submitted
        foreach ($questions as $question) {
            $question->is_submitted = 1; // Mark as submitted
            $question->save();
        }

        // Add a session flash message for finalized quiz
        session()->flash('finalized_quiz_id', $quizId);

        // Redirect to quizzes index
        return redirect()->route('quizzes.index')->with('success', 'All questions for this quiz have been submitted.');
    }
}