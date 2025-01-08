<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quizzes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Quizzes</h1>
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">Create Quiz</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Subject Type</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Subject Name</th>
                    <th>Faculty Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $index => $quiz)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $quiz->subject_type }}</td>
                        <td>{{ $quiz->department }}</td>
                        <td>{{ $quiz->semester }}</td>
                        <td>{{ $quiz->subject_name }}</td>
                        <td>{{ $quiz->faculty_name }}</td>
                        <td>{{ $quiz->date }}</td>
                        <td>{{ $quiz->start_time }}</td>
                        <td>{{ $quiz->end_time }}</td>
                        <td>
                            @if ($quiz->is_submitted)
                                <div class="alert alert-warning">
                                    Questions for this quiz are finalized and cannot be modified or added.
                                </div>
                            @else
                                <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-primary btn-sm">Add
                                    Question</a>
                            @endif
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
