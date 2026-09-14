function validateRegistration()
{

    let fullName = document.getElementById("full_name").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let role = document.getElementById("role").value;


    if(!fullName)
    {
       document.getElementById("fullnameError").innerHTML = "Full Name is required";
        return false;
    }
    else
        {
            document.getElementById("fullnameError").innerHTML = "";
        }


    let namePattern = /^[a-zA-Z ]+$/;


    if(!namePattern.test(fullName))
    {
    
        document.getElementById("fullnameError").innerHTML = "Full Name cannot contain numbers or special characters";
        return false;
    }
    else
        {
            document.getElementById("fullnameError").innerHTML = "";
        }


    if(!username)
    {
        document.getElementById("usernameError").innerHTML = "Username is required";
        return false;
    }
    else
        {
            document.getElementById("usernameError").innerHTML = "";
        }



    if(!password)
    {
        
        document.getElementById("passwordError").innerHTML ="Password is required";
        return false;
    }
    else
        {
            document.getElementById("passwordError").innerHTML ="";
        }



    if(password.length < 4)
    {
       
        document.getElementById("passwordError").innerHTML = "Password must be at least 4 characters";
        return false;
    }
    else
        {
            document.getElementById("passwordError").innerHTML = "";
        }



    if(role == "")
    {
         document.getElementById("roleError").innerHTML = "Please select a role";
        return false;
    }
    else
        {
            document.getElementById("roleError").innerHTML = "";
        }



    return true;

}
