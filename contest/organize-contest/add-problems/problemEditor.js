const addTestCaseButton = document.getElementById("add-input-test-case-box");
    const inputContainer = document.getElementById("input-test-case-container");
    let testCaseCount = 1;
    

    // addTestCaseButton.addEventListener("click", function() {
    //     // Create a new input field for the test case
    //     const newTestCaseDiv = document.createElement("div");
    //     newTestCaseDiv.classList.add("input-test-case");

    //     const label = document.createElement("label");
    //     label.setAttribute("for", "input-example-test-case-" + testCaseCount);
    //     label.textContent = "Test Case: " + testCaseCount;

    //     const textarea = document.createElement("textarea");
    //     textarea.setAttribute("id", "input-example-test-case-" + testCaseCount);
    //     textarea.setAttribute("rows", "5");

    //     newTestCaseDiv.appendChild(label);
    //     newTestCaseDiv.appendChild(textarea);
    //     inputContainer.appendChild(newTestCaseDiv);

    //     testCaseCount++;
    // });
    var id, description, example, correct_code, sample_test_case, prefix_code, postfix_code, empty_code,problem_title;

    $.ajax({
        url: "admin/edit_problem.php",
        type: "GET",
        dataType: "json",
        success: (data) => {
            console.log(data);
            $('#input-problem-id').text(data.id);
            $('#input-problem-description').text(data.description);
            $('#input-problem-example').text(data.example);
            $('#input-correct-code').text(data.Correct_code);
            $('#input-example-test-cases').text(data.sample_test_case);
            $('#input-prefix-code').text(data.prefix_code);
            $('#input-postfix-code').text(data.postfix_code);
            $('#input-empty-code').text(data.empty_code);
            $('#input-problem-title').text(data.title);
            
            // Iterate over test cases from 1 to 6
            for (let i = 1; i <= 6; i++) {
                // Construct the key for the test case
                let testCaseKey = "testCase" + i;
                // Check if the test case key exists in the data
                if (testCaseKey in data) {
                    // Set the value of the corresponding textarea to the test case
                    $('#input-test-case-' + i).val(data[testCaseKey]);
                } else {
                    console.log("Test case not found for key: " + testCaseKey);
                }
            }
        },
        error: (err) => {
            console.log(err.responseText);
        }
    });
    

    $('#submit').click(function() {
        // Initialize variables
        var problemId = $('#input-problem-id').val();
        var problemTitle = $('#input-problem-title').val();
        var problemDescription = $('#input-problem-description').val();
        var problemExample = $('#input-problem-example').val();
        var problemPrefixCode = $('#input-prefix-code').val();
        var problemPostfixCode = $('#input-postfix-code').val();
        var emptyCode = $('#input-empty-code').val();
        var correctCode = $('#input-correct-code').val();
        var exampleTestCase = $('#input-example-test-cases').val();
        var TestCase1  = $('#input-test-case-1').val();
        var TestCase2  = $('#input-test-case-2').val();
        var TestCase3  = $('#input-test-case-3').val();
        var TestCase4  = $('#input-test-case-4').val();
        var TestCase5  = $('#input-test-case-5').val();
        var TestCase6  = $('#input-test-case-6').val();

        // Initialize an array to store test cases
        

        // console.log(testCases);

        // Create an object to store all form data
        var formData = {
            problemId: problemId,
            problemTitle: problemTitle,
            problemDescription: problemDescription,
            problemExample: problemExample,
            problemPrefixCode: problemPrefixCode,
            problemPostfixCode: problemPostfixCode,
            emptyCode: emptyCode,
            correctCode: correctCode,
            exampleTestCase: exampleTestCase,
            testCase1: TestCase1,
            testCase2: TestCase2,
            testCase3: TestCase3,
            testCase4: TestCase4,
            testCase5: TestCase5,
            testCase6: TestCase6
        };

        // Send data via AJAX
        $.ajax({
            type: 'POST',
            url: 'admin/insert_problem_data.php',
            data: formData,
            success: function(response) {
                // Handle success response
                console.log('Data submitted successfully:', response);
                history.back();
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert("");
                console.error('Error:', error);
            }
        });


    });

    $('#cancel').click(function(){
        history.back();
    });
