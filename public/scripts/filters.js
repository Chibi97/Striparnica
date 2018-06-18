$(document).ready(function() {
  filters.init();
  filters.getAllComics();
});

var filters = (function() {
  function init() {
    $(".sub-items").hide();
    $(".title i").css("transition", "all ease 450ms");
    $(".sub-items").each((i, el) => $(el).data('height', $(el).height())); 
    $(".title").click(handleClick);
    $(".filter").click(handleFilterClick);

    var urlString = window.location.href;
    var url = new URL(urlString);
    var defaultFilter = url.searchParams.get("filter");
    if(defaultFilter) {
      var found = null;
      $(".search-text").each((i, el) => {
        if($(el).text() == defaultFilter) {
          found = $(el);
          return;
        }
      });
      if(found) {
        var title = found.closest('.sub-items').siblings('.title');
        title.click();
        found.click();
         var half = $(window).height() / 2;
         setTimeout(function() {
          $("html, body").animate({
            scrollTop: found.offset().top - half
          }, 750);
         }, 450);
         
      }
    }
  }

  function handleFilterClick() {
    var ids = $(".filter")
      .filter(function() { return this.checked; })
      .map(function() { return $(this).val() })
      .toArray();

    var data = {ids: ids}
    ajaxPost("ajax/comics.php", data,
      (resp)    => {
        console.log(resp);
      },
      (status)  => {
        console.log(status);
      }
    );
  }

  function getAllComics(page) {
    var page = page || 1;
    ajaxPost("ajax/comics.php", {page: page}, 
    (resp) => {
      iscrtajSve(resp);
      iscrtajNav(resp)
    },
    (status) => {
      console.log(status);
    });
  }

  function iscrtajNav(resp) {
    $(".comics-control").html("");
    for(let i=0; i<resp.total;i++) {
      let link = $(`<a href='#'>${i+1}</a>`);
      link.css({"fontSize": "3.4rem", "margin": "1em"});
      link.click(function(e) {
        e.preventDefault();
        getAllComics(i+1);
      });
      $(".comics-control").append(link);
    }
  }

  function iscrtajJednog(comic) {
    return `<div class='comic'>
        <img src='${comic.path}' alt=${comic.alt}'/>
        <h2>${comic.name}</h2>
        <div class='aid'>
          <a href='#' data-id='${comic.id}' class='btn-style bs-white'>UPDATE</a>
          <a href = '#' data-id = '${comic.id}'
           class = 'btn-style bs-white' > DELETE </a>
          <a href = '#' data-id = '${comic.id}'
           class = 'btn-style bs-white' > ADD </a>
        </div>
        <p class='scroll'>${comic.description}
        </p>
        <div class='info'>
          <p><strong>Issues/Chapters:</strong> ${comic.issues}</p>
          <p><strong>Rating:</strong> ${comic.votes}</p>
        </div>
      </div>`;
  }

  function iscrtajSve(resp) {
    var html = "";
    resp.data.forEach((comic) => {
      html += iscrtajJednog(comic);
    });
    $(".comics").html(html);
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
    init: init,
    getAllComics: getAllComics
  };
})();