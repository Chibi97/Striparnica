function ajaxGet(url, cbSuccess, cbFailure) {
  __ajax(url, cbSuccess, cbFailure, "GET");
}

function ajaxPost(url, data, cbSuccess, cbFailure) {
  __ajax(url, cbSuccess, cbFailure, "POST", data);
}

function __ajax(url, cbSuccess, cbFailure, verb, data) {
  var data = data || {};
  $.ajax({
    url: url,
    dataType: "json",
    method: verb,
    success: cbSuccess,
    data: data,
    error: function(xhr, statusText, msg) {
      cbFailure(xhr.status, xhr.responseText);
    }
  })
}