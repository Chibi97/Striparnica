$(document).ready(function() {
  slider.init();
  $("#slide-left").click(slider.slideLeft);
});

var slider = (function () {
  var index, slideAmount;

  function init() {
    index = 1;
    slideAmount = $(".image-slider img").eq(0).outerWidth(true);
    $(".image-slider").css('transition', 'all ease 1s');
  }

  function slideLeft() {
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
    index++;
  }

  return {
    init: init,
    slideLeft: slideLeft
  }
})();