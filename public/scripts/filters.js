$(document).ready(function() {
  filters.init();
});

var filters = (function() {
  
  function init() {
    $(".sub-items").hide();
    $(".title i").css("transition", "all ease 450ms");
    $(".sub-items").each((i, el) => $(el).data('height', $(el).height())); 
    $(".title").click(handleClick);
  }

  function handleClick() {
    var elem = $(this).parent().find('.sub-items');
    var toHeight = elem.data('height');
    var carret = $(this).find('i');
    
    elem.finish();

    if(!elem.data("expanded")) {
      elem.css("height", 0).show();
      elem.animate({height: toHeight + "px"}, 450);
      elem.data("expanded", true);
      carret.addClass('go');
    } else {
      elem.animate({height: 0}, 450);
      elem.data("expanded", false);
      carret.removeClass('go');
    }
  }

  return {
    init: init
  };
})();