const join_compition_btn = document.getElementById('join-compition-btn');
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
        profile_nav.href = "./Auth/login";
        }else{
            profile_nav.textContent = "Profile"   ;
        profile_nav.href = "./profile.html";
        }   
    }
})


join_compition_btn.onclick = ()=>{
    window.location.href='./contest/contest_description.html';
}