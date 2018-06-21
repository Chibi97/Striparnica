$(document).ready(function() {
  filters.init();
  filters.getAllComics();
});

var myList = (function() {
  function init() {
    var add = $(".add");
    var remove = $(".remove");
    add.click(handleAdd);
    remove.click(handleRemove);
  }


  function handleRemove(e) {
    e.preventDefault();
    var id = $(this).data("id");
    ajaxPost("ajax/removeFromList.php", {
          stripId: id
        },
      () => {
        console.log("uspeh");
      },
      (status) => {
        console.log(status);
      });
  }

  function handleAdd(e) {
    e.preventDefault();
    var id = $(this).data("id");
    ajaxPost("ajax/addToList.php", {
          stripId: id
        },
      () => {
        console.log("uspeh");
      },
      (status) => {
        console.log(status);
      });
  }

  return {
    init: init
  }
})();

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

    var data = {ids: ids};
    ajaxPost("ajax/comics.php", data,
      (resp)    => {
        iscrtajSve(resp);
        iscrtajNav(resp);
      },
      (status)  => {
        console.log(status);
      }
    );
  }

  function getAllComics(page) {
    var page = page || 1;
    var ids = $(".filter")
      .filter(function () { return this.checked; })
      .map(function () { return $(this).val() })
      .toArray();
    ajaxPost("ajax/comics.php", {
      page: page,
      ids: ids
    },
    (resp) => {
      iscrtajSve(resp);
      myList.init();
      iscrtajNav(resp);
    },
    (status) => {
      console.log(status);
    });
  }
 
  function iscrtajNav(resp) {
    console.log(resp.total);
    var div = $(".comics-control");
    div.html("");
    for(let i=0; i<resp.total;i++) {
      let link = $(`<a href='#'>${i+1}</a>`);
      link.css(
        {
        "fontSize": "3rem", 
        "margin": "1em",
        "color": "#666A86"
        });
      link.click(function(e) {
        e.preventDefault();
        getAllComics(i+1);
      });
      div.append(link);
    }
  }

  function iscrtajJednog(comic, loggedIn) {
    var remove = "";
    var add = "";
    console.log("ID: " + comic.id + " je: " + comic.flag);
    if (loggedIn) {
      if (!comic.flag) {
        add = `<a href='#' data-id='${comic.id}' class='btn-style bs-white add-to-list add'>ADD</a>`;
      } else {
        remove = `<a href='#' data-id='${comic.id}' class='btn-style bs-white add-to-list remove'>REMOVE</a>`;
      }
    }
    
    return `<div class='comic'>
              <img src='${comic.path}' alt='${comic.alt}' />
              <h2>${comic.name}</h2>
              <div class='aid ar-btn'>
                ${add}
                ${remove}
              </div>
              <p class='scroll'>${comic.description}</p>
              <div class='info'>
                <p><strong>Issues/Chapters: </strong>${comic.issues}</p>
                <p><strong>Number of votes: </strong>${comic.votes}</p>
              </div>
            </div>`;
  }

  function iscrtajSve(resp) {
    var html = "";
    var loggedIn = resp.loggedIn;
    resp.data.forEach((comic) => {
      html += iscrtajJednog(comic, loggedIn);
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