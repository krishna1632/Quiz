<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style for the final submit button at the bottom-right */
        .final-submit-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }
    </style>
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
                            <td>{{ $question->options[$question->correct_option] ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('questions.edit', $question->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if (!$questions->isEmpty())
        <div class="container mt-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="confirmCorrect" name="confirmCorrect"
                    onclick="toggleSubmitButton()">
                <label class="form-check-label" for="confirmCorrect">
                    All questions and its options are correct.
                </label>
            </div>
        </div>

        <!-- Final Submit Button -->
        <a href="{{ route('questions.submit', $quiz->id) }}" class="btn btn-secondary final-submit-btn"
            id="finalSubmitBtn" onclick="disableCheckbox()" disabled>Final Submit</a>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to toggle the submit button based on checkbox status
        function toggleSubmitButton() {
            const checkbox = document.getElementById('confirmCorrect');
            const submitButton = document.getElementById('finalSubmitBtn');

            if (checkbox.checked) {
                submitButton.disabled = false; // Enable button
                submitButton.classList.remove('btn-secondary'); // Remove secondary color
                submitButton.classList.add('btn-success'); // Add success color
            } else {
                submitButton.disabled = true; // Disable button
                submitButton.classList.remove('btn-success'); // Remove success color
                submitButton.classList.add('btn-secondary'); // Add secondary color
            }
        }

        // Function to disable the checkbox after final submit and redirect
        function disableCheckbox() {
            function disableCheckbox() {
                const checkbox = document.getElementById('confirmCorrect');
                if (checkbox.checked) {
                    checkbox.disabled = true; // Disable the checkbox
                    alert('All questions and options are now marked as correct and cannot be changed.');
                    // Clear the current page content and redirect
                    document.body.innerHTML = '';
                    window.location.href = "{{ route('quizzes.index') }}";
                } else {
                    alert('Please confirm that all questions and options are correct by checking the box.');
                }
            }
    </script>
</body>

</html>
