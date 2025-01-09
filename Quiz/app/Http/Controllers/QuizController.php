<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with('questions')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $request->validate([
            'subject_type' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'faculty_name' => 'required|string|max:255',
            'date' => "required|date|after_or_equal:$currentDate",
            'start_time' => [
                'required',
                function ($attribute, $value, $fail) use ($currentDate, $currentTime, $request) {
                    if ($request->date === $currentDate && $value < $currentTime) {
                        $fail('Start time must be equal to or after the current time for today.');
                    }
                },
            ],
            'end_time' => [
                'required',
                function ($attribute, $value, $fail) use ($currentDate, $currentTime, $request) {
                    if ($request->date === $currentDate && $value < $currentTime) {
                        $fail('End time must be equal to or after the current time for today.');
                    }
                    if ($value <= $request->start_time) {
                        $fail('End time must be after the start time.');
                    }
                },
            ],
        ]);

        $quiz = Quiz::create($request->all());
        return redirect()->route('questions.index', ['quiz' => $quiz->id])->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the quiz and its related questions
        $quiz = Quiz::findOrFail($id);  // Ensure quiz exists
        $questions = Question::where('quiz_id', $id)->get();  // Get questions related to the quiz

        // Return the view with quiz details and questions
        return view('quizzes.show', compact('quiz', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);  // Fetch quiz by ID
        return view('quizzes.edit', compact('quiz'));  // Return the edit view with quiz details
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quiz = Quiz::findOrFail($id);  // Fetch quiz by ID

        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Validate incoming data
        $request->validate([
            'subject_type' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'faculty_name' => 'required|string|max:255',
            'date' => "required|date|after_or_equal:$currentDate",
            'start_time' => [
                'required',
                function ($attribute, $value, $fail) use ($currentDate, $currentTime, $request) {
                    if ($request->date === $currentDate && $value < $currentTime) {
                        $fail('Start time must be equal to or after the current time for today.');
                    }
                },
            ],
            'end_time' => [
                'required',
                function ($attribute, $value, $fail) use ($currentDate, $currentTime, $request) {
                    if ($request->date === $currentDate && $value < $currentTime) {
                        $fail('End time must be equal to or after the current time for today.');
                    }
                    if ($value <= $request->start_time) {
                        $fail('End time must be after the start time.');
                    }
                },
            ],
        ]);

        // Update the quiz
        $quiz->update($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);  // Fetch quiz by ID
        $quiz->delete();  // Delete the quiz

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}