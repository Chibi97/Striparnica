$(document).ready(function() {
  slider.init();
  $("#slide-left").click(slider.slideLeft);
  $("#slide-right").click(slider.slideRight);
  $(".image-slider-wrap").on('touchmove', slider.handleTouch);
  $(".image-slider-wrap").on('touchstart', slider.handleTouchStart);
  $(".image-slider-wrap").on('touchend', slider.handleTouchEnd);

});

var slider = (function () {
  var index, slideAmount;
  var lastTouchX, touchedPos, sliderPosition;

  function init() {
    index = 0;
    lastPos = 0;
    sliderPosition = 0;
    slideAmount = $(".image-slider img").eq(0).outerWidth(true);
    length = $(".image-slider img").length;
    $(".image-slider").css('transition', 'all ease 1s');
  }

  function handleTouchStart(e) {
    e.preventDefault();
    if(e.targetTouches.length == 1) {
      var touch = e.targetTouches[0];
      touchedPos = touch.pageX + sliderPosition;
    }
    $(".image-slider").css("transition", "");
  }

  function handleTouch(e) {
    e.preventDefault();
    if (e.targetTouches.length == 1) {
      var touch = e.targetTouches[0];
      var movement = touchedPos - touch.pageX;

      $(".image-slider").css({
        transform: `translateX(${-movement}px)`
      });

      sliderPosition = movement;
    }
  }

  function handleTouchEnd() {
    $(".image-slider").css('transition', 'all ease 1s');
  }

  function slideLeft() {
    index++;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
    lastPos = -toSlide;
  }
  
  function slideRight() {
    if(index - 1 < 0) return;
    index--;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
    lastPos = -toSlide;
  }

  return {
    init: init,
    slideLeft: slideLeft,
    slideRight: slideRight,
    handleTouch: handleTouch,
    handleTouchStart: handleTouchStart,
    handleTouchEnd: handleTouchEnd
  }
})();