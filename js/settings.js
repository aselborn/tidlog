
    function checkCurrentPassword(usr, oldPwd){
       let xhr = new XMLHttpRequest();
       let url = './code/util.php';
       
    }


    function ChangePassword(usr){

        var inOldPwd = $("#idCurrentPassword").val();
        var inNewPwd = $("#idNewPassword").val();

        var data = { nameOfFunction : 'change_password', user_id: usr, old_pwd: inOldPwd, new_pwd: inNewPwd };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).change_password === 'false'){
                    alert('Fel uppstod => ' + JSON.parse(response).orsak);
                    return;
                } else if (JSON.parse(response).change_password ==='true'){
                    alert('Ditt lösenord är ändrat!');
                }
            }

        });
    }


    function UploadImage(imageData)
    {

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

    
