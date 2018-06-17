$(document).ready(function() {
  $('form[name="login-forma"]').submit(function(e) {
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var errors = {};
    var validno  = {};
    var returnEmail = validateEmail(email, errors, validno);
    var returnPass = validatePassword(password, errors, validno);
    
    if(!(returnEmail && returnPass)) {
      e.preventDefault();
      prikazGresaka(errors);
    }
  });
});

function prikazGresaka(errors) {
  if(errors.password) {
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
