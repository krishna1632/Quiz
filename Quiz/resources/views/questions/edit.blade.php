<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Question for Quiz: {{ $quiz->title }}</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="questionForm" action="{{ route('questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden field for quiz_id -->
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

            <!-- Question Text -->
            <div class="mb-3">
                <label for="question_text" class="form-label">Write Your Question</label>
                <input type="text" name="question_text" class="form-control" id="question_text"
                    value="{{ old('question_text', $question->question_text) }}" required>
            </div>

            <!-- Options Container -->
            <div id="optionsContainer">
                @foreach ($question->options as $index => $option)
                    <!-- Directly use options as an array -->
                    <div class="mb-3">
                        <input type="text" name="options[]" class="form-control"
                            value="{{ old('options.' . $index, $option) }}" required>
                    </div>
                @endforeach
            </div>

            <!-- Correct Option -->
            <div class="mb-3" id="correctOptionContainer">
                <label for="correct_option" class="form-label">Choose the Correct Option</label>
                <select name="correct_option" id="correct_option" class="form-select" required>
                    @foreach ($question->options as $index => $option)
                        <option value="{{ $index }}" {{ $question->correct_option == $index ? 'selected' : '' }}>
                            Option {{ $index + 1 }}: {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>
