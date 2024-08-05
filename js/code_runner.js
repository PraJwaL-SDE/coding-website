
const navbar = document.getElementById("navbar");
const navLeftContainer = document.getElementById("nav-left-container");
const navMidContainer = document.getElementById("nav-mid-container");
const runButton = document.getElementById("run-button");
const submitButton = document.getElementById("submit-button");
const navRightContainer = document.getElementById("nav-right-container");

const bodyContainer = document.getElementById("body-container");
const leftContainer = document.getElementById("left-container");
const problemTitle = document.getElementById("problem-title");
const problemTypeContainer = document.getElementById("problem-type-container");
const problemLevel = document.getElementById("problem-level");
const problemTopics = document.getElementById("problem-topics");
const problemDescription = document.getElementById("problem-description");
const exampleContainer = document.getElementById("example-container");
const constrainContainer = document.getElementById("constrain-container");
const problemReviewContainer = document.getElementById("problem-review-container");
const likeOption = document.getElementById("like-option");
const likeCount = document.getElementById("like-count");
const dislikeCount = document.getElementById("dislike-count");

const rightContainer = document.getElementById("right-container");
const codeEditorContainer = document.getElementById("code-editor-container");
const codeTitle = document.getElementById("code-title");
const codeEditorOptionContainer = document.getElementById("code-editor-option-container");
const languageOption = document.getElementById("language-option");
const codeEditor = document.getElementById("code-editor");
const textBoxCode = document.getElementById("textbox-code");

const testCasesContainer = document.getElementById("test-cases-container");
const testCaseTitle = document.getElementById("test-case-title");
const testCaseScrollableContainer = document.getElementById("test-case-scrollable-container");
const testCaseOptionRow = document.getElementById("test-case-option-row");
const testCaseButton1 = document.getElementById("test-case-button");
const testCaseButton2 = document.getElementById("test-case-button");
const testCaseButton3 = document.getElementById("test-case-button");
const testCaseInputContainer = document.getElementById("test-case-input-container");
const testCaseTextArea = document.getElementById("test-case-textarea");
const outputBox = document.getElementById("outputBox");
const closeOutputDialog = document.getElementById("close-output-dialog");
const outputText = document.getElementById('outputText');

closeOutputBox()

runButton.addEventListener('click', function() {
    openOutputBox();
    var code = textBoxCode.value;
    var outputDiv = outputText;
    outputDiv.textContent = 'Compiling and running...';
    var inputFromTestCase = testCaseTextArea.value;

    // Combine code and test case into a single payload
    var requestData = 'code=' + encodeURIComponent(code) + '&CustomTestCase=' + encodeURIComponent(inputFromTestCase);

    // Send code and test case together in one XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'compileJava.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);

            outputDiv.textContent = 'Compiling and running...'; // Update message

            // Send GET request to get_output.php
            var xhrGet = new XMLHttpRequest();
            xhrGet.open('GET', 'get_output.php', true);
            xhrGet.onreadystatechange = function() {
                if (xhrGet.readyState == 4 && xhrGet.status == 200) {
                    console.log("Responce " + xhrGet.responseText);
                    var responseGet = JSON.parse(xhrGet.responseText);
                    if (responseGet.success) {
                        outputDiv.textContent = responseGet.output;
                    } else {
                        outputDiv.textContent = 'Error getting output: ' + responseGet.error;
                    }
                }
            };
            xhrGet.send(); // Send request to get_output.php
        }
    };
    xhr.send(requestData); // Send code and test case together
});





closeOutputDialog.onclick=closeOutputBox;


function openOutputBox() {
    var height = 0;
    var increment = 1;
    var maxHeight = 50;
    outputBox.style.display = "flex";
    var interval = setInterval(function() {
        if (height >= maxHeight) {
            clearInterval(interval);
        } else {
            height += increment;
            outputBox.style.height = height + "vh";
        }
    }, 10);
}

function closeOutputBox() {
    var height = 50;
    var decrement = 1;
    var minHeight = 0;
    var interval = setInterval(function() {
        if (height <= minHeight) {
            clearInterval(interval);
            outputBox.style.display = "none";
        } else {
            height -= decrement;
            outputBox.style.height = height + "vh";
        }
    }, 10);
}

function loadProblemDetails(problem){
    problemTitle.textContent = problem.title;
    problemLevel.textContent = problem.level;
    problemDescription.textContent = problem.desciption;
    exampleContainer.textContent = problem;
    
}



