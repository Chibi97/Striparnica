$(document).ready(function() {
  loginValidation();
  registerValidation();
});

function loginValidation() {
  $('form[name="login-forma"]').submit(function (e) {
    var errors = {};
    var validno = {};
    if (!validateLoginParams(errors, validno)) {
      e.preventDefault();
      prikazGresaka(errors);
    }
  });
}

function validateLoginParams(errors, validno) {
  var validations = [];
  var email = $("input[name='email']").val();
  var password = $("input[name='password']").val();
  validations.push(validateEmail(email, errors, validno));
  validations.push(validatePassword(password, errors, validno));

  return !validations.includes(false);
}

function registerValidation() {
  $('form[name="reg-forma"]').submit(function (e) {
    var errors = {};
    var validno = {};
    if (!validateRegistrationParams(errors, validno)) {
      e.preventDefault();
      prikazGresaka(errors);
    }
  });
}

function validateRegistrationParams(errors, validno) {
  var validations = [];
  var email    = $("input[name='reg-email']").val();
  var password = $("input[name='reg-password']").val();
  var confirm  = $("input[name='reg-confirm']").val();
  validations.push(validateEmail(email, errors, validno));
  validations.push(confirmPassword(password, confirm, errors));
  validations.push(validatePassword(password, errors, validno));

  return !validations.includes(false);
  // ako nadje bilo koje false u nizu, vratice true, sto znaci da moramo sa ! da kazemo da to bude false -- neuspesno
}

function validateEmail(email, errors, validno) {
  var reEmail = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
  if(!reEmail.test(email)) {
    errors.email = "!!!You must enter a valid format for email address";
    return false;
  } else {
    validno.email = email;
    return true;
  }
}

function validatePassword(password, errors, validno) {
   var rePass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
   if(!rePass.test(password)) {
     errors.password = "!!!A password must have at least one digit, at least one uppercase char, lowercase chars and it should be at least 8 chars long";
    return false;
  } else {
    validno.password = password;
    return true;
  }
}

function confirmPassword(password, confirm, errors) {
  if(password != confirm) {
    errors.confirm = "!!!Your passwords are not matching";
    return false;
  } else {
    return true;
  }
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

  if (errors.confirm) {
    $(".errConfirm").html(errors.confirm);
    $(".fa-unlock").css("color", "crimson");
  } else {
    $(".errConfirm").html("");
    $(".fa-unlock").css("color", "#333");
  }
}

