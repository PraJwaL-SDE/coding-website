const solveBtn = document.getElementById('solve-btn2');
// alert("hello");
$(document).ready(function() {
    function load_data(){
        $.ajax({
            url: 'server/show_problem_list.php',
            type: 'POST',
            success: function(data) {
                $('.problem-list-container').html(data);
            }
        });
    }
    load_data();

    
    
    $(document).on('click',"#solve-btn",function(){
        let problemId = $(this).data('eid');
        // alert(problemId);
        
        $.ajax({
            url: 'admin/set_id_to_edit.php',
            type: 'POST',
            data: {ProblemId:problemId},
            success: function(data) {
                // alert(data);
                location.href = "./problems/code_runner.html";
            }
                
        });
    });
    
});
const profile_nav = document.getElementById('profile_nav');

$.ajax({
    type:'GET',
    url:'Auth/check_auth.php',
    success:function(response) {
        // Handle success response
        console.log(response);
        if(response==0){
        // window.location.href = 'login.html';      
        profile_nav.textContent = "Login"   ;
        profile_nav.href = "./login.html";
        }else{
            profile_nav.textContent = "Profile"   ;
        profile_nav.href = "./profile.html";
        }   
    }
})




// solveBtn.addEventListener('click', () => {
//     window.open('http://localhost/seminar/code_runner.html', '_self');
// });
