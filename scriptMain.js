function validateForm()
{
    // Get Values
    let name = document.getElementById().value.trim();
    let surname = document.getElementById().value.trim();
    let email = document.getElementById().value.trim();
    let phone = document.getElementById().value.trim();
    let password = document.getElementById().value.trim();

    // Error messages
    let nameError = document.getElementById("nameError");
    let surnameError = document.getElementById("surnameError");
    let emailError = document.getElementById("emailError");
    let phoneError = document.getElementById("phoneError");
    let passwordError = document.getElementById("passwordError");

    // Clear Errors
    nameError.innerHTML = "";
    surnameError.innerHTML = "";
    emailError.innerHTML = "";
    phoneError.innerHTML = "";
    passwordError.innerHTML = "";
    let isValid = true;
    if (name === "")
    {
        nameError.innerHTML = "Name is required";
        isValid = false;
    }
    if (surname === "")
    {
        surnameError.innerHTML = "Surname is required";
        isValid = false;
    }
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (email === "")
    {
        emailError.innerHTML = "Email is required";
        isValid = false;
    } else if (!email.match(emailPattern))
    {
        emailError.innerHTML = "Invalid email format";
        isValid = false;
    }
    let phonePattern = /^\d{10,}$/;
    if (phone === "")
    {
        phoneError.innerHTML = "Phone is required";
        isValid = false;
    } else if (!phone.match(phonePattern))
    {
        phoneError.innerHTML = "Invalid phone format";
        isValid = false;
    }
    if (password === "")
    {
        passwordError.innerHTML = "Password is required";
        isValid = false;
    } else if (password.length < 8)
    {
        passwordError.innerHTML = "Password must be at least 8 characters long";
        isValid = false;
    }

    return isValid;
}

function validateLoginForm()
{
    // Getting the values
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    // Get error messages
    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");

    // Clear Errors
    emailError.innerHTML = "";
    passwordError.innerHTML = "";
    let isValid = true;

    if (email === "")
    {
        emailError.innerHTML = "Email is required";
        isValid = false;
    }
    if (password === "")
    {
        passwordError.innerHTML = "Password is required";
        isValid - false;
    }

    return isValid;
}