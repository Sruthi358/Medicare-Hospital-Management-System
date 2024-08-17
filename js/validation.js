function seterror(id, error) {
    var element = document.getElementById(id);
    element.getElementsByClassName('formerror')[0].innerHTML = error;
}

function clearErrors() {
    var errors = document.getElementsByClassName('formerror');
    for (var i = 0; i < errors.length; i++) {
        errors[i].innerHTML = "";
    }
    console.log("Errors cleared");
}

function hasSymbol(password) {
    const symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    return symbolRegex.test(password);
}

function hasNumber(password) {
    const numberRegex = /\d/;
    return numberRegex.test(password);
}

function hasDot(email) {
    const emailRegex = /.@/;
    return emailRegex.test(email);
}

function validateGender() {
    var radios = document.getElementsByName('gender');
    var isChecked = false;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            isChecked = true;
            break;
        }
    }
    if (!isChecked) {
        seterror("gender", "*Please select a gender");
        return false;
    }
    return true;
}

function validateLanguage() {
    var check = document.getElementsByName('languages[]');
    var isChecked = false;
    for (var i = 0; i < check.length; i++) {
        if (check[i].checked) {
            isChecked = true;
            break;
        }
    }
    if (!isChecked) {
        seterror("language", "*Please choose a language");
        return false;
    }
    return true;
}

function validateForm_reg(event) {
    // console.log("hello");
    var returnval = true;
    clearErrors();

    var name = document.forms['registration']['name'].value;
    if (name == '') {
        seterror("uname", "*Field is required");
        returnval = false;
    }

    var name = document.forms['registration']['u_name'].value;
    if (name == '') {
        seterror("u_uname", "*Field is required");
        returnval = false;
    }

    var email = document.forms['registration']['email'].value;
    if (email == '') {
        seterror("uemail", "*Field is required");
        returnval = false;
    } else if (!email.endsWith('@gmail.com') || !hasNumber(email)) {
        seterror("uemail", "*Enter valid email address");
        returnval = false;
    }

    var dob = document.forms['registration']['dob'].value;
    if (dob == '') {
        seterror("udob", "*Field is required");
        returnval = false;
    }

    var phno = document.forms['registration']['phno'].value;
    if (phno == '') {
        seterror("uphno", "*Field is required");
        returnval = false;
    }

    if (phno.length != 10) {
        seterror("uphno", "*Enter valid phone number");
        returnval = false;
    }

    if (!validateGender()) {
        returnval = false;
    }

    var area = document.forms['registration']['area'].value;
    if (area == '') {
        seterror("uarea", "*Field is required");
        returnval = false;
    }

    var city = document.forms['registration']['city'].value;
    if (city == '') {
        seterror("ucity", "*Field is required");
        returnval = false;
    }

    var state = document.forms['registration']['state'].value;
    if (state == '') {
        seterror("ustate", "*Field is required");
        returnval = false;
    }

    var code = document.forms['registration']['code'].value;
    if (code == '') {
        seterror("ucode", "*Field is required");
        returnval = false;
    }

    var password = document.forms['registration']['password'].value;
    if (password == '') {
        seterror("upassword", "*Field is required");
        returnval = false;
    }

    if (password.length < 6 || !hasSymbol(password) || !hasNumber(password)) {
        seterror("upassword", "*Minimum length of password must be 6<br>*Password must contain a symbol<br>*Password must contain a number");
        returnval = false;
    }

    var cpassword = document.forms['registration']["cpassword"].value;
    if (cpassword == '') {
        seterror("ucpassword", "*Re-enter the password");
        returnval = false;
    }

    if (cpassword != password) {
        seterror("ucpassword", "*Password and Confirm password must be same");
        returnval = false;
    }

    if (!returnval) {
        event.preventDefault();
    }
    console.log("hello im in scrip");
    return returnval;
}

function validateForm_login(event) {
    var returnval = true;
    clearErrors();

    var selectedOption = document.forms['loginForm']['user'].value;
    if (selectedOption == '#') {
        seterror("select", "*Please select a user type");
        returnval = false;
    }

    var name = document.forms['loginForm']['username'].value;
    if (name == '') {
        seterror("uusername", "*Field is required");
        returnval = false;
    }

    var password = document.forms['loginForm']["password"].value;
    if (password == '') {
        seterror("upassword", "*Field is required");
        returnval = false;
    }

    if (!returnval) {
        event.preventDefault();
    }

    return returnval;
}

function validateForm_add_doctor(event) {
    var returnval = true;
    clearErrors();

    var name = document.forms['registration']['name'].value;
    if (name == '') {
        seterror("uname", "*Field is required");
        returnval = false;
    }

    var name = document.forms['registration']['u_name'].value;
    if (name == '') {
        seterror("u_uname", "*Field is required");
        returnval = false;
    }

    var email = document.forms['registration']['email'].value;
    if (email == '') {
        seterror("uemail", "*Field is required");
        returnval = false;
    }
    else if (!hasDot(email)) {
        seterror("uemail", "*Enter valid email address");
        returnval = false;
    }

    var dob = document.forms['registration']['dob'].value;
    if (dob == '') {
        seterror("udob", "*Field is required");
        returnval = false;
    }

    var phno = document.forms['registration']['phno'].value;
    if (phno == '') {
        seterror("uphno", "*Field is required");
        returnval = false;
    }

    if (phno.length != 10) {
        seterror("uphno", "*Enter valid phone number");
        returnval = false;
    }

    if (!validateGender()) {
        returnval = false;
    }

    if (!validateLanguage()) {
        returnval = false;
    }

    var qualification = document.forms['registration']['qualification'].value;
    if (qualification == '') {
        seterror("uqualification", "*Field is required");
        returnval = false;
    }

    var selectedOption = document.forms['registration']['speciality'].value;
    if (selectedOption == '#') {
        seterror("select", "*Please select a speciality");
        returnval = false;
    }

    var area = document.forms['registration']['area'].value;
    if (area == '') {
        seterror("uarea", "*Field is required");
        returnval = false;
    }

    var city = document.forms['registration']['city'].value;
    if (city == '') {
        seterror("ucity", "*Field is required");
        returnval = false;
    }

    var state = document.forms['registration']['state'].value;
    if (state == '') {
        seterror("ustate", "*Field is required");
        returnval = false;
    }

    var code = document.forms['registration']['code'].value;
    if (code == '') {
        seterror("ucode", "*Field is required");
        returnval = false;
    }

    var password = document.forms['registration']['password'].value;
    if (password == '') {
        seterror("upassword", "*Field is required");
        returnval = false;
    }
    if (password.length < 6 || !hasSymbol(password) || !hasNumber(password)) {
        seterror("upassword", "*Minimum length of password must be 6<br>*Password must contain a symbol<br>*Password must contain a number");
        returnval = false;
    }

    var cpassword = document.forms['registration']["cpassword"].value;
    if (cpassword == '') {
        seterror("ucpassword", "*Re-enter the password");
        returnval = false;
    }

    if (cpassword != password) {
        seterror("ucpassword", "*Password and Confirm password must be same");
        returnval = false;
    }
    if (!returnval) {
        event.preventDefault();
    }

    return returnval;
}


