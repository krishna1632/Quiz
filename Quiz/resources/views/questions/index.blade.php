<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Questions List</h1>
        <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-primary mb-4">Add Question</a>
        <!-- Add Questions Later button -->
        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary mb-4 ml-2">Add Questions Later</a>

        @if ($questions->isEmpty())
            <div class="alert alert-info">
                No questions available. Please add a new question.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Correct Option</th>
                        <th>Actions</th>
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
                            <td>{{ json_decode($question->options, true)[$question->correct_option - 1] ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('questions.edit', ['quizId' => $quiz->id, 'id' => $question->id]) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Checkbox and Final Submit Button -->
            <div class="mt-4">
                <input type="checkbox" id="confirmFinalize">
                <label for="confirmFinalize">I confirm that all questions are correct and finalized.</label>
            </div>
            <div>
                <form method="POST" action="{{ route('questions.submit', $quiz->id) }}">
                    @csrf
                    <button id="finalSubmit" class="btn btn-success mt-2" disabled>Final Submit</button>
                </form>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('confirmFinalize')?.addEventListener('change', function() {
            const finalSubmitButton = document.getElementById('finalSubmit');
            finalSubmitButton.disabled = !this.checked;
        });
    </script>
</body>

</html>
