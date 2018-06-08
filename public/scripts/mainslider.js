$(document).ready(function() {
  slider.init();
  $("#slide-left").click(slider.slideLeft);
  $("#slide-right").click(slider.slideRight);
});

var slider = (function () {
  var index, slideAmount;

  function init() {
    index = 0;
    slideAmount = $(".image-slider img").eq(0).outerWidth(true);
    length = $(".image-slider img").length;
    $(".image-slider").css('transition', 'all ease 1s');
  }

  function slideLeft() {
    index++;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
  }
  
  function slideRight() {
    if(index - 1 < 0) return;
    index--;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
  }

  return {
    init: init,
    slideLeft: slideLeft,
    slideRight: slideRight
  }
})();