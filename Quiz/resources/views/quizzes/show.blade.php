<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Quiz Details Section -->
        <h1>Quiz Details</h1>
        <div class="mb-4">
            <strong>Subject Type:</strong> {{ $quiz->subject_type }}<br>
            <strong>Department:</strong> {{ $quiz->department }}<br>
            <strong>Semester:</strong> {{ $quiz->semester }}<br>
            <strong>Subject Name:</strong> {{ $quiz->subject_name }}<br>
            <strong>Faculty Name:</strong> {{ $quiz->faculty_name }}<br>
            <strong>Date:</strong> {{ $quiz->date }}<br>
            <strong>Start Time:</strong> {{ $quiz->start_time }}<br>
            <strong>End Time:</strong> {{ $quiz->end_time }}<br>
        </div>

        <!-- Questions List Section -->
        <h2>Questions List</h2>

        @if ($questions->isEmpty())
            <div class="alert alert-info">
                No questions available for this quiz.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Correct Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $index => $question)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $question->question_text }}</td>
                            <td>
                                <ul>
                                    @foreach (json_decode($question->options, true) as $key => $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @php
                                    $options = json_decode($question->options, true);
                                    $correctOptionIndex = $question->correct_option - 1; // Adjust for 0-based index
                                    $correctOption = $options[$correctOptionIndex] ?? 'N/A';
                                @endphp
                                {{ $correctOption }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary mb-4">Back to Quizzes</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
