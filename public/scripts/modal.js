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
  $(".modal").find("span").click(function () {
    if (window.modalOpen) {
      closeModal();
    }
  });

  /*$("body").click(function () {
    if (window.modalOpen) {
      closeModal();
    }
  });*/
}

function closeModal() {
  window.modalOpen = false;
  $(".modal").removeClass("show");
  $("#crnilo").remove();
}

function openModal() {
  window.modalOpen = true;
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