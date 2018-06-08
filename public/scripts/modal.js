$(document).ready(function () {
  initModal();

  if (window.modalOpen) openModal();

  $("#login").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    openModal();
  });
});

function initModal() {
  $(".modal button").click(() => closeModal());

  $(".modal").find("span").click(function () {
    if (window.modalOpen) {
      closeModal();
    }
  });

  $(document).click(function (e) {
    if($(e.target).closest('.modal').length
      || e.target == '#login') return;

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

function openModal() {
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
  $("body").prepend(crnilo);
}