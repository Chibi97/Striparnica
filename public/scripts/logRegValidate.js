$(document).ready(function() {
  loginValidation();
  registerValidation();
});

function loginValidation() {
  $('form[name="login-forma"]').submit(function (e) {
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var errors = {};
    var validno = {};
    var validateEmail = validateEmail(email, errors, validno);
    var validatePass = validatePassword(password, errors, validno);

    if (!(validateEmail && validatePass)) {
      e.preventDefault();
      prikazGresaka(errors);
    }
  });
}

function registerValidation() {
  var email    = $("input[name='reg-email']").val();
  var password = $("input[name='reg-password']").val();
  var confirm  = $("input[name='reg-confirm']").val();
  var errors = {};
  var validno = {};
  var validateEmail = validateEmail(email, errors, validno);
  var validatePass  = false;

  $('form[name="reg-forma"]').submit(function (e) {
    if (validatePassword(password, errors, validno)) {
      var confirmPass = confirmPassword(password, confirm, errors);
    }
    if (!(validateEmail && confirmPass)) {
      e.preventDefault();
      prikazGresaka(errors);
    }
  });
}

function prikazGresaka(errors) {
  if (errors.password) {
    $(".errPass").html(errors.password);
    $(".fa-key").css("color", "crimson");
  } else {
    $(".errPass").html("");
    $(".fa-key").css("color", "#333");
  }

  if (errors.email) {
    $(".errEmail").html(errors.email);
    $(".fa-at").css("color", "crimson");
  } else {
    $(".errEmail").html("");
    $(".fa-at").css("color", "#333");
  }

  if(errors.confirm) {
    $(".errEmail").html(errors.email);
    $(".fa-unlock").css("color", "crimson");
  } else {
    
  }
}

function validateEmail(email, errors, validno) {
  var reEmail = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
  if(!reEmail.test(email)) {
    errors.email = "You must enter a valid format for email address";
    return false;
  } else {
    validno.email = email;
    return true;
  }
}

function validatePassword(password, errors, validno) {
   var rePass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
   if(!rePass.test(password)) {
     errors.password = "A password must have at least one digit, at least one uppercase char, lowercase chars and it should be at least 8 chars long";
    return false;
  } else {
    validno.password = password;
    return true;
  }
}

function confirmPassword(password, confirm, errors) {
  if(password != confirm) {
    errors.confirm = "Your passwords are not matching";
    return false;
  } else {
    return true;
  }
}

