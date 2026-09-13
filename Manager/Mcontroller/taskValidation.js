function validateCreateTask()
{

    let title = document.getElementById("task-title").value;
    let description = document.getElementById("task-description").value;
    let dueDate = document.getElementById("task-date").value;
    let assignedTo = document.getElementById("team-leader").value;


    if(!title)
    {
        document.getElementById("titleError").innerHTML = "Task title is required";
        return false;
    }
    else
    {
        document.getElementById("titleError").innerHTML = "";
    }



    if(!description)
    {
        document.getElementById("descriptionError").innerHTML = "Description is required";
        return false;
    }
    else
    {
        document.getElementById("descriptionError").innerHTML = "";
    }



    if(!dueDate)
    {
        document.getElementById("dueDateError").innerHTML = "Due date is required";
        return false;
    }
    else
    {
        document.getElementById("dueDateError").innerHTML = "";
    }



    if(!assignedTo)
    {
        document.getElementById("assignedError").innerHTML = "Please select team leader";
        return false;
    }
    else
    {
        document.getElementById("assignedError").innerHTML = "";
    }



    return true;

}





function validateEditTask()
{

    let title = document.getElementById("task-title").value;
    let description = document.getElementById("task-description").value;
    let dueDate = document.getElementById("task-date").value;
    let assignedTo = document.getElementById("team-leader").value;



    if(!title)
    {
        document.getElementById("titleError").innerHTML = "Task title is required";
        return false;
    }
    else
    {
        document.getElementById("titleError").innerHTML = "";
    }



    if(!description)
    {
        document.getElementById("descriptionError").innerHTML = "Description is required";
        return false;
    }
    else
    {
        document.getElementById("descriptionError").innerHTML = "";
    }



    if(!dueDate)
    {
        document.getElementById("dueDateError").innerHTML = "Due date is required";
        return false;
    }
    else
    {
        document.getElementById("dueDateError").innerHTML = "";
    }



    if(!assignedTo)
    {
        document.getElementById("assignedError").innerHTML = "Please select team leader";
        return false;
    }
    else
    {
        document.getElementById("assignedError").innerHTML = "";
    }



    return true;

}