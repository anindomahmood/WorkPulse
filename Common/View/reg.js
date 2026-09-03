function validateRegistration()
{

    let fullName = document.getElementById("full_name").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let role = document.getElementById("role").value;


    if(fullName == "")
    {
        alert("Full Name is required");
        return false;
    }


    let namePattern = /^[a-zA-Z ]+$/;


    if(!namePattern.test(fullName))
    {
        alert("Full Name cannot contain numbers or special characters");
        return false;
    }



    if(username == "")
    {
        alert("Username is required");
        return false;
    }



    if(password == "")
    {
        alert("Password is required");
        return false;
    }



    if(password.length < 4)
    {
        alert("Password must be at least 4 characters");
        return false;
    }



    if(role == "")
    {
        alert("Please select a role");
        return false;
    }



    return true;

}