const problemContainer = document.getElementById("problem-container");
// const problem = document.getElementById("problem");
// const problemId = document.getElementById("problem-id");
// const problemTitle = document.getElementById("problem-title");
// const problemDifficulty = document.getElementById("problem-difficulty");
// const temp = document.getElementById("temp");
// const editBtn = document.getElementById("edit-btn");
// const deleteBtn = document.getElementById("delete-btn");



// for(let i = 0;i<100;i++){

//     let problem = createElement('div',"problem","problem","");
//     problem.appendChild(
//         createElement('div',"problem-id" ,"problem-id",`${i+1}`)
//     );
//     problem.appendChild(
//         createElement('div',"problem-title" ,"problem-title","Three Sum")
//     );
//     problem.appendChild(
//         createElement('div',"problem-difficulty" ,"problem-difficulty","Easy")
//     );
//     const editButton = createElement('button', "problem-edit-btn", "problem-edit-btn", "Edit");
//     editButton.addEventListener('click', openProblemEditior);
//     problem.appendChild(editButton);
//     problem.appendChild(
//         createElement('button',"problem-delete-btn" ,"problem-delete-btn","Delete")
//     );
//     problemContainer.appendChild(problem);
// }
$(document).ready(function() {
    function load_data(){
        $.ajax({
            url: './load_data.php',
            type: 'POST',
            success: function(data) {
                $('#problem-container').html(data);
            }
        });
    }
    load_data();

    $('#add-problem').click(function(){
        location.href = "problemEditor.html";
    });

    
    $(document).on('click',"#edit-btn",function(){
        let problemId = $(this).data('eid');
        // alert(problemId);
        
        $.ajax({
            url: 'set_id_to_edit.php',
            type: 'POST',
            data: {ProblemId:problemId},
            success: function() {
                // alert(problemId);
                location.href = "problemEditor.html";
            }
                
        });
    });
    $(document).on('click',"#delete-btn",function(){
        let problemId = $(this).data('eid');
        alert(problemId);
        
        // $.ajax({
        //     url: 'admin/delete_problem_data.php',
        //     type: 'POST',
        //     data: {ProblemId:problemId},
        //     success: function(response) {
        //         load_data();
        //         console.log(response);                
        //     }
                
        // });
    });
});






function createElement(elementType, id, className,text) {
    const element = document.createElement(elementType);
    if (id) {
        element.id = id;
    }
    if (className) {
        element.className = className;
    }
    element.textContent = text;
    return element;
}


