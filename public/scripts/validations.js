$(document).ready(function() {
  loginValidation();
  registerValidation();
  handleVote();
});

function loginValidation() {
  $('form[name="login-forma"]').submit(function (e) {
    var errors = {};
    var validno = {};
    if (!validateLoginParams(errors, validno)) {
      e.preventDefault();
      prikazGresaka(errors, $(this));
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
      prikazGresaka(errors, $(this));
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

function prikazGresaka(errors, forma) {
  if (errors.password) {
    forma.find('.errPass').html(errors.password);
    forma.find(".fa-key").css("color", "crimson");
  } else {
    forma.find('.errPass').html("");
    forma.find(".fa-key").css("color", "#333");
  }

  if (errors.email) {
    forma.find('.errEmail').html(errors.email);
    forma.find(".fa-at").css("color", "crimson");
  } else {
    forma.find('.errEmail').html("");
    forma.find(".fa-at").css("color", "#333");
  }

  if (errors.confirm) {
    forma.find('.errConfirm').html(errors.confirm);
    forma.find(".fa-unlock").css("color", "crimson");
  } else {
    forma.find('.errConfirm').html("");
    forma.find(".fa-unlock").css("color", "#333");
  }
}

function results(resp) {
  var html = "";
  if(resp.poruka) {
    var response = resp.poruka;
    $(".already-voted").html(response);
    $(".vote-msg").show();
  } else {
    resp.forEach((result) => {
      html += iscrtajSliku(result);
    });
    $(".last-added").html(html);
  }
 
}

function iscrtajSliku(jedna) {
  return `<figure class='l3-item'>
            <img src='${jedna.path}' alt='${jedna.alt}' />
          <figcaption class='l3-desc'>
            <p>${jedna.name}</p>
          </figcaption>
        </figure>`;
}

function handleVote() {
  $(".vote-msg").hide();
  $("#vote").change(function () {
    var value = Number($(this).val());
    if (value > 0) {
      ajaxPost("ajax/addVote.php", {
        votedFor: value
      },
      (resp) => {
        console.log(resp);
        results(resp);
      },
      (status, responseText) => {
        console.log(responseText);
      });
    }
  });

  $(".vote-msg a").click(function (e) {
    if(value > 0) {
      ajaxGet("ajax/removeVote.php",
      (resp) => {
        console.log(resp);
      },
      (status, responseText) => {
        console.log(responseText);
      });
    } else {
      e.preventDefault();
    }
  });
}

