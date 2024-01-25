

    // $("#btnChange").on('click', function(){

    //     var userName = '<?php echo $userName; ?>';
        


    //     var currentPwdDb = getPassword(userName);
    //     checkPwd(currentPwdDb);
    // });

    function checkCurrentPassword(usr, oldPwd){
       let xhr = new XMLHttpRequest();
       let url = './code/util.php';
       
    }


    function ChangePassword(usr){
        alert(usr);
    }


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

    
