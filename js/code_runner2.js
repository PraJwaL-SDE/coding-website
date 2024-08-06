// const { error } = require("jquery");



const navbar = document.getElementById("navbar");
const navLeftContainer = document.getElementById("nav-left-container");
const navMidContainer = document.getElementById("nav-mid-container");
const runButton = document.getElementById("run-button");
const submitButton = document.getElementById("submit-btn");
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

var outputDiv = outputText;

closeOutputBox();
var id, description, example, correct_code, test_case, prefix_code, postfix_code, empty_code,problem_title;
var pid = 1;
$.ajax({
    url: 'admin/get_id.php',
    type: 'GET',    
    success: function(data) {
        console.log(data);
        pid = Number.parseInt(data);
        $.ajax({
            url : "Server/load_problem.php",
            type : "POST",
            data:{id : pid},
            dataType: "json",
            success : (data)=>{
                textBoxCode.textContent = data.empty_code;
                testCaseTextArea.textContent = data.test_case;
                 id = data.id;
                //  description = data.description;
                // description.innerHTML = data.description;
                document.getElementById('problem-data-load').innerHTML = data.description;
                 example = data.example;
                 correct_code = data.Correct_code;
                 test_case = data.test_case;
                 prefix_code = data.prefix_code;
                 postfix_code = data.postfix_code;
                 empty_code = data.empty_code;
                 problem_title = data.title;
        
                 problemDescription.textContent = description;
                 problemTitle.textContent = problem_title;
        
        
        
            },
            error: function(error) {
                console.log(error.responseText  );
            }
        
        });
    }        
});







runButton.addEventListener('click', function() {
    openOutputBox();
    var code = textBoxCode.value;

    code = prefix_code + code + postfix_code;
    console.log("Code : "+code);
    
    outputDiv.innerHTML = 'Compiling and running...';
    var inputFromTestCase = testCaseTextArea.value;   
        $.ajax({
            url : "compilers/java_compile_run_check.php",
        type : "POST",
        data : {code:code,CustomTestCase:inputFromTestCase,correct_code : correct_code},
            success : function (data) {
                console.log("Success data send "+data);
                // $.ajax({
                //     url : "get_output.php",
                //     type : "GET",
                //     success : (output)=>{
                //         console.log(output);

                //         modifyOutput(output);
                //         // outputDiv.innerHTML = `Test Case : ${i+1}/50`;
                //     }
                // });
                checkOutput();
                
            }
        });   
});
function checkOutput() {
    $.ajax({
        url: "compilers/get_output.php",
        type: "GET",
        success: function(output) {
            console.log(output);
            if (output.trim() !== "Trying to connect with server") {
                // Output matches, take further action
                // outputDiv.innerHTML = output;
                modifyOutput(output);
            } else {
                modifyOutput(output);
                // Output doesn't match yet, check again after 1 second
                setTimeout(checkOutput, 1000); // Check again after 1 second
            }
        }
    });
}

// Call the function to start checking output
// checkOutput();

submitButton.addEventListener('click',function (){
    openOutputBox();
    var code = textBoxCode.value;
    code = prefix_code + code + postfix_code;
    outputDiv.innerHTML = 'Compiling and running...';
    var inputFromTestCase = testCaseTextArea.value;
    var intervalId;
    console.log("Code : "+code);
    $.ajax({
        url : "compilers/java_submit_test_case_compiler.php",
        type : "POST",
        data : {code:code,CustomTestCase:inputFromTestCase,correct_code : correct_code,problemId:id},
        success : function (data) {
            clearInterval(intervalId); 
            $.ajax({
                url: "compilers/get_output.php",
                type: "GET",
                success: function(output) {
                    // outputDiv.innerHTML = output;   
                    modifyOutput(output);                 
                }
            });
            
        }
    });
    

    function getOutput() {
        $.ajax({
            url: "compilers/get_output.php",
            type: "GET",
            success: function(output) {
                outputDiv.innerHTML = output;               
                console.log(".");
            }
        });
    }

    // Call getOutput initially
    getOutput();

    // Start the interval and assign the ID to intervalId
    intervalId = setInterval(getOutput, 1000);

});



function modifyOutput(output){
    // Split the output into an array of lines
    if (output.indexOf("C:\\Users\\Kambl\\AppData\\Local\\Temp\\") != -1) {
        output = output.replace("C:\\Users\\Kambl\\AppData\\Local\\Temp\\", "");
    }
    var lines = output.split('\n');
    output = output.replace(/\n/g, "<br>");

    output = output.replace(/C:\\Users\\Kambl\\AppData\\Local\\Temp\\/g, "");

    outputDiv.innerHTML = output;
    if (lines.length === 1) {
        console.log("Onlhy one line")
        return;
    }
    
    


    
    // outputDiv.textContent = '';
    var count = 0;
    // Append each line to the output element
    // lines.forEach(function(line) {
    
    //     console.log(line);
    //     line = line.replace('\n', '');
    //     line = line.replace("C:\\Users\\Kambl\\AppData\\Local\\Temp\\", "");
        
    //     var textNode = document.createTextNode(line);
        
    //     // Append the text node to the output element
    //     outputDiv.appendChild(textNode);
        
    //     // Create a line break element
    //     var br = document.createElement('br');
        
    //     // Append the line break element to the output element
    //     outputDiv.appendChild(br);
    // });
}



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



