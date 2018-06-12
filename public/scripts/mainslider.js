$(document).ready(function() {
  slider.init();
  $("#slide-left").click(slider.slideRight);
  $("#slide-right").click(slider.slideLeft);
  $(".image-slider-wrap").on('touchmove', slider.handleTouch);
  $(".image-slider-wrap").on('touchstart', slider.handleTouchStart);
  $(".image-slider-wrap").on('touchend', slider.handleTouchEnd);
  $(window).on('resize', slider.haandleResize);
});

var slider = (function () {
  var index, slideAmount, imagesShown, imageCount;
  var lastTouchX, touchedPos, sliderPosition;

  function init() {
    index = 0;
    lastPos = 0;
    sliderPosition = 0;
    imageCount = $(".image-slider img").length;
    slideAmount = $(".image-slider img").eq(0).outerWidth(true);
    length = $(".image-slider img").length;
    $(".image-slider").css('transition', 'all ease 1s');
    syncImageCount();
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

  function syncImageCount() {
    var imageWidth = $(".image-slider img").eq(1).outerWidth(true);
    var sliderWidth = $(".image-slider-wrap").width();
    imagesShown = Math.ceil(sliderWidth / imageWidth);
  }
  function handleResize() {
    syncImageCount();
  }

  function handleTouchEnd() {
    $(".image-slider").css('transition', 'all ease 1s');
  }

  function toMaxIndex() {
    var jumpIndex = imageCount - imagesShown;
    index = jumpIndex;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
    lastPos = -toSlide;
  }     

  function revertToZero() {
    index = 0;
    $(".image-slider").css({transform: "translateX(0)"})
    lsatPos = 0;
  }

  function slideLeft() {
    if(index + imagesShown > imageCount - 1) {
      revertToZero();
      return;
    }
    index++;
    var toSlide = index * slideAmount;
    $(".image-slider").css({
      transform: `translateX(${-toSlide}px)`
    });
    lastPos = -toSlide;
  }
  
  function slideRight() {
    if(index - 1 < 0) {
      toMaxIndex();
      return;
    }
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
    handleTouchEnd: handleTouchEnd,
    haandleResize: handleResize
  }
})();