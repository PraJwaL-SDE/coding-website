document.addEventListener("DOMContentLoaded", function() {
    const buttonCountSelect = document.getElementById("buttonCount");
    const problemDiv = document.getElementById("problem");

    buttonCountSelect.addEventListener("change", function() {
        const selectedCount = parseInt(buttonCountSelect.value);
        createButtons(selectedCount);
    });

    function createButtons(count) {
        problemDiv.innerHTML = ""; // Clear previous buttons

        for (let i = 1; i <= count; i++) {
            const button = document.createElement("button");
            const buttonContainer = document.createElement("div"); // Create a div container
            buttonContainer.classList.add("button-container"); // Optionally add a class to the container
            button.textContent = "Add Problem " + i;
            button.classList.add("dynamic-button");
            button.setAttribute("data-id", i);
            button.addEventListener("click", function() {
                AddQuestion(i);
            });
            buttonContainer.appendChild(button); // Append the button to the container
            problemDiv.appendChild(buttonContainer);
        }
    }

    // Initial creation of buttons based on the default value of the select
    createButtons(parseInt(buttonCountSelect.value));

    function AddQuestion(ProblemId) {
        $.ajax({
            type: "POST",
            url: "../../API/set_problem_id.php",
            data: {
                ProblemId: ProblemId
            },
            success: function(response) {
                console.log(response);
                // alert(response);
                if (response == 1) {
                    window.location.href = './add-problems/problemEditor.html';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    $(document).ready(function() {
        $('#contestForm').submit(function(event) {
            event.preventDefault(); 
                var formData = {
                organizer: $('#organizer').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                date: $('#date').val(),
                timeFrom: $('#time-from').val(),
                timeTo: $('#time-to').val(),
                format: $('#format').val(),
                motive: $('#motive').val(),
                benefit1: $('#benefit1').val(),
                benefit2: $('#benefit2').val(),
                benefit3: $('#benefit3').val(),
                benefit4: $('#benefit4').val(),
                organizerAbout: $('#organizer-about').val(),
                totalQue: $('#buttonCount').val()
            };
    
            // Send data via AJAX
            $.ajax({
                type: 'POST',
                url: 'admin/insert_contest_data.php',
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log('Data submitted successfully:', response);
                    // Optionally, you can redirect or show a success message here
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                    // Optionally, you can show an error message here
                }
            });
        });
    });
    
});
