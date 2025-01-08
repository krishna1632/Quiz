<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Quiz</h1>
        <form id="quizForm" action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- To specify it's a PUT request for update -->

            <div class="mb-3">
                <label for="subject_type" class="form-label">Subject Type</label>
                <input type="text" name="subject_type" class="form-control" id="subject_type"
                    value="{{ old('subject_type', $quiz->subject_type) }}" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" name="department" class="form-control" id="department"
                    value="{{ old('department', $quiz->department) }}" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="text" name="semester" class="form-control" id="semester"
                    value="{{ old('semester', $quiz->semester) }}" required>
            </div>
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" name="subject_name" class="form-control" id="subject_name"
                    value="{{ old('subject_name', $quiz->subject_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="faculty_name" class="form-label">Faculty Name</label>
                <input type="text" name="faculty_name" class="form-control" id="faculty_name"
                    value="{{ old('faculty_name', $quiz->faculty_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date"
                    value="{{ old('date', $quiz->date) }}" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" class="form-control" id="start_time"
                    value="{{ old('start_time', $quiz->start_time) }}" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" class="form-control" id="end_time"
                    value="{{ old('end_time', $quiz->end_time) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Quiz</button>
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('quizForm').addEventListener('submit', function(event) {
            const currentDate = new Date().toISOString().split('T')[0];
            const currentTime = new Date().toTimeString().split(' ')[0];

            const dateInput = document.getElementById('date').value;
            const startTimeInput = document.getElementById('start_time').value;
            const endTimeInput = document.getElementById('end_time').value;

            if (dateInput < currentDate) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date',
                    text: 'Date cannot be earlier than today!'
                });
                return;
            }

            if (dateInput === currentDate && startTimeInput < currentTime) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Start Time',
                    text: 'Start time cannot be earlier than the current time!'
                });
                return;
            }

            if (dateInput === currentDate && endTimeInput < currentTime) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid End Time',
                    text: 'End time cannot be earlier than the current time!'
                });
                return;
            }

            if (startTimeInput >= endTimeInput) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Time Range',
                    text: 'End time must be after the start time!'
                });
            }
        });
    </script>
</body>

</html>
