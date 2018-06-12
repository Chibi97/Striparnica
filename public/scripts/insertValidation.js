$(document).ready(function() {
  var comicName = $("#comicName").val();
  var desc = $("#desc").val();
  var num = $(".dial").val();

   $(".dial").knob({
     'min': 1,
     'max': 2000
   });

  $("#insertComic").click(function(e) {
    e.preventDefault();
    var errors = {};
    var validno = {};
    validateName(comicName, errors, validno);
    validateDesc(desc, errors, validno);
    validateIssueNum(errors, validno);

    console.log($(".dial").val());
    console.log(num);

    console.log("Errors:");
    console.log(errors);
    console.log("Valid:");
    console.log(validno);
  });
});

function validateName(comicName, errors, validno) {
  var reName = /^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}|[0-9]{1,4}(\.)*))*$/;
  if(!reName.test(comicName)) {
    errors.comicName = "Every first letter of a word must be a capital letter";
  } else {
    validno.comicName = comicName;
  }
}

function validateDesc(desc, errors, validno) {
  if (desc.length < 10) {
    errors.desc = "You need to write more than 10 characters";
  } else {
    validno.desc = desc;
  }
}

function validateIssueNum(errors, validno) {
  if ($(".dial").val() < 2 || $(".dial").val() > 2000) {
    errors.num = "Number of issues cannot be zero or less";
  } else {
    validno.num = $(".dial").val();
  }
}

function validateSubfilters(chosen, errors, validno) {
  
}