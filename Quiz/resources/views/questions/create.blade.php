<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Create Question</h1>

        <form id="questionForm" action="{{ route('questions.store', $quiz->id) }}" method="POST">
            @csrf
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            <div class="mb-3">
                <label for="question_text" class="form-label">Write Your Question</label>
                <input type="text" name="question_text" class="form-control" id="question_text" required>
            </div>

            <div class="mb-3">
                <label class="form-label">How many options do you want to create?</label>
                <div>
                    <input type="radio" name="option_count" value="1" id="one_option"> Only one option<br>
                    <input type="radio" name="option_count" value="2" id="two_options"> Two options<br>
                    <input type="radio" name="option_count" value="3" id="three_options"> Three options<br>
                    <input type="radio" name="option_count" value="4" id="four_options"> Four options<br>
                    <input type="radio" name="option_count" value="5" id="other_options"> Others<br>
                </div>
            </div>

            <div id="optionsContainer"></div>

            <div class="mb-3" id="correctOptionContainer" style="display: none;">
                <label for="correct_option" class="form-label">Choose the Correct Option</label>
                <select name="correct_option" id="correct_option" class="form-select" required></select>
            </div>

            <div id="addedQuestionsList"></div>

            <button type="button" class="btn btn-secondary mb-3" id="addAnotherQuestion">Add Another Question</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const optionsContainer = document.getElementById('optionsContainer');
        const correctOptionContainer = document.getElementById('correctOptionContainer');
        const correctOptionSelect = document.getElementById('correct_option');
        const addedQuestionsList = document.getElementById('addedQuestionsList');
        const questionForm = document.getElementById('questionForm');

        // Handle radio button change for number of options
        document.querySelectorAll('input[name="option_count"]').forEach(radio => {
            radio.addEventListener('change', function() {
                optionsContainer.innerHTML = '';
                correctOptionSelect.innerHTML = '';

                const optionCount = this.value;

                if (optionCount === '5') {
                    const inputField = document.createElement('input');
                    inputField.type = 'number';
                    inputField.className = 'form-control mb-3';
                    inputField.placeholder = 'Enter number of options';
                    inputField.id = 'dynamicOptionCount';

                    inputField.addEventListener('input', function() {
                        generateOptions(parseInt(this.value));
                    });

                    optionsContainer.appendChild(inputField);
                } else {
                    generateOptions(parseInt(optionCount));
                }
            });
        });

        // Dynamically generate option fields
        function generateOptions(count) {
            optionsContainer.innerHTML = '';
            correctOptionSelect.innerHTML = '';

            for (let i = 1; i <= count; i++) {
                const optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = `options[${i}]`;
                optionInput.className = 'form-control mb-3';
                optionInput.placeholder = `Option ${i}`;
                optionsContainer.appendChild(optionInput);

                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Option ${i}`;
                correctOptionSelect.appendChild(option);
            }

            correctOptionContainer.style.display = count > 0 ? 'block' : 'none';
        }

        // Add another question logic
        document.getElementById('addAnotherQuestion').addEventListener('click', function() {
            const questionText = document.getElementById('question_text').value;
            const optionCount = Array.from(document.querySelectorAll('input[name="option_count"]'))
                .find(radio => radio.checked)?.value;
            const options = Array.from(optionsContainer.querySelectorAll('input[name^="options"]'))
                .map(input => input.value);
            const correctOption = correctOptionSelect.value;

            if (!questionText || !optionCount || options.length === 0 || !correctOption) {
                Swal.fire('Error', 'Please fill out all fields before adding another question.', 'error');
                return;
            }

            // Display the added question
            const questionDiv = document.createElement('div');
            questionDiv.className = 'card p-3 mb-3';
            questionDiv.innerHTML = `
            <h5>Question: ${questionText}</h5>
            <p>Options:</p>
            <ul>
                ${options.map(opt => `<li>${opt}</li>`).join('')}
            </ul>
            <p>Correct Option: ${options[correctOption - 1]}</p>
        `;
            addedQuestionsList.appendChild(questionDiv);

            // Reset options for next question
            optionsContainer.innerHTML = '';
            correctOptionContainer.style.display = 'none';
            document.getElementById('question_text').value = ''; // Reset question text
            document.querySelector('input[name="option_count"]:checked').checked = false; // Uncheck options count
        });

        // Handle form submission
        questionForm.addEventListener('submit', function(event) {
            const questionText = document.getElementById('question_text').value;
            const optionCount = Array.from(document.querySelectorAll('input[name="option_count"]'))
                .find(radio => radio.checked)?.value;
            const options = Array.from(optionsContainer.querySelectorAll('input[name^="options"]'))
                .map(input => input.value);
            const correctOption = correctOptionSelect.value;

            if (!questionText || !optionCount || options.length === 0 || !correctOption) {
                event.preventDefault();
                Swal.fire('Error', 'Please fill out all fields before submitting.', 'error');
                return;
            }

            // Manually submit the form if everything is valid
            questionForm.submit();
        });
    </script>
</body>

</html>
