$(document).ready(function() {

    $("#btnChange").on('click', function(){
        var currentPwdDb = getPassword('nisse');
        
        checkPwd(currentPwdDb);
    });

    

    function checkPwd(currentUser){
        
        var currentPwdDb = getPassword(currentUser)
        var currentPwdUser = $("#idCurrentPassword").val();

        if (currentPwdDb !== currentPwdUser){
            alert('Ditt befintliga lösenord, stämmer inte!');
            return;
        }

        var newPassword = $("#idNewPassword").val();

        

    };

    function getPassword(currentUser){
        return "kalle";
    }

    
});