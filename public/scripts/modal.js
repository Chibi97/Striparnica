$(document).ready(function () {
  initModal();

  if (window.modalOpen) {
    if(window.turnModal) {
      openModal('register');
    } else {
      openModal();
    }
  }
  $(".open-modal-login").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    openModal();
  });

  $(".open-modal-register").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    openModal('register');
  });
});

function initModal() {
 // $("#login").click(() => closeModal());
  $("#register-btn").click((e) => {
    e.preventDefault();
    $(".modal .card").addClass('is-flipped');
  });
  $("#login-btn").click((е) => {
    е.preventDefault();
    $(".modal .card").removeClass('is-flipped');
  });

  
  $(".modal").find(".modal-exit").click(function () {
    if (window.modalOpen) {
      closeModal();
    }
  });

  $(document).click(function (e) {
    if($(e.target).closest('.modal').length
      || e.target == '.open-modal-login') return;

    if (window.modalOpen) {
      closeModal();
    }
  });
}

function closeModal() {
  window.modalOpen = false;
  $(".modal").removeClass("show");
  $(".modal").addClass('hide');
  $("#crnilo").remove();
}

function openModal(rotation) {
  window.modalOpen = true;
  $(".modal").removeClass('hide');
  var crnilo = $("<div id='crnilo'>");
  crnilo.css({
    display: "block",
    position: "fixed",
    width: "100%",
    height: "100%",
    background: "rgba(0, 0, 0, 0.6)",
    zIndex: 999
  });

  $(".modal").addClass("show");
  if(typeof rotation == 'undefined') {
    rotation = "login"
  }

  if(rotation == 'login') {
    if($('.modal .card').hasClass('is-flipped')) {
      $('.modal').on('animationend', () => $('.modal .card').removeClass('is-flipped'))
    }
  } else if(rotation == 'register') {
    if(!$('.modal .card').hasClass('is-flipped')) {
      $('.modal').on('animationend', () => $('.modal .card').addClass('is-flipped'))
    }
  }
  $("body").prepend(crnilo);
}