<?php include_once "admin_nav.php" ?>
<div class='flex-row center legend'>
  <ul>
    <li class='series-a'>Favorites</li>
    <li class='series-b'>Votes</li>
  </ul>
</div>
<div class='chart-container'>
</div>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    ajaxGet("/ajax/comicStats.php", (data) => {
      let comics = data.reduce((acc, stat) => {
        acc[stat.name] = {favorites: stat.favorite_count, votes: stat.vote_num};
        return acc;
      }, {});


      var data = {
        labels: Object.keys(comics),
        series: [
          Object.values(comics).map((metric) => metric.votes),
          Object.values(comics).map((metric) => metric.favorites)
        ]
      };

      var options = {
        axisY: {
          onlyInteger: true,
        },
        seriesBarDistance: 50
      };

      new Chartist.Bar('.chart-container', data, options).on('draw', function(data) {
        if(data.type === 'bar') {
          data.element.attr({
            style: 'stroke-width: 30px'
          });
        }
      });
    });
  });
</script>
