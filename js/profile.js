$(document).ready(function() {
    // AJAX request to fetch profile data
    $.ajax({
        type: 'GET',
        url: 'server/get_profile_data.php', // Replace 'get_profile_data.php' with your server endpoint
        dataType: 'json', // Expect JSON response
        success: function(data) {
            // Update profile data
            $('#profile-name').text(data.name);
            $('#profile-email').text('Email: ' + data.email);
            $('#profile-username').text('Username: ' + data.username);
            $('#profile-joined').text('Joined: ' + data.joined);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while fetching profile data.');
        }
    });

    

});
function logout(){
    $.ajax({
        type:'GET',
        url: 'Auth/logout.php',
        success:function(data){
            if(data == '1')
            location.href = 'home.html';
            else
            alert(data);
            
        }
    })
}
