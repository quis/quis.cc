<nav>
  <h3>
    Trips
  </h3>
  <ul>
    <li><a href="/trips/scotland-2020/">Scotland 2020</a></li>
    <li><a href="/trips/canada-2019/">Canada 2019</a></li>
    <li><a href="/trips/alps-2019/">Alps 2019</a></li>
    <li><a href="/trips/california-2018/">California 2018</a></li>
    <li><a href="/trips/salzburg-2018/">Salzburg 2018</a></li>
    <li><a href="/trips/north-america-2018/">North America 2018</a></li>
    <li><a href="/trips/innsbruck-2018/">Innsbruck 2018</a></li>
    <li><a href="/trips/switzerland-2017/">Switzerland 2017</a></li>
    <li><a href="/trips/portugal-2017/">Portugal 2017</a></li>
    <li><a href="/trips/les-arcs-2017/">Les Arcs 2017</a></li>
    <li><a href="/trips/barcelona-2016/">Barcelona 2016</a></li>
    <li><a href="/trips/portugal-2016/">Portugal 2016</a></li>
    <li><a href="/trips/cinque-terre-2016/">Cinque Terre 2016</a></li>
    <li><a href="/trips/zermatt-2016/">Zermatt 2016</a></li>
    <li><a href="/trips/cyprus-2015/">Cyprus 2015</a></li>
    <li><a href="/trips/pyrenees-2015/">Pyrenees 2015</a></li>
    <li><a href="/trips/morocco-2014/">Morocco 2014</a></li>
    <li><a href="/trips/europe-2014/">Europe 2014</a></li>
    <li><a href="/trips/texas-2014/">Texas 2014</a></li>
    <li><a href="/trips/new-zealand-2013-2014/">New Zealand 2013–2014</a></li>
    <li><a href="/trips/scotland-2013/">Scotland 2013</a></li>
    <li><a href="/trips/europe-2013/">Europe 2013</a></li>
    <li><a href="/trips/australia-2011-2012/">Australia 2011–2012</a></li>
    <li><a href="/trips/usa-2011/">USA 2011</a>
    <li><a href="/trips/scotland-2010/">Scotland 2010</a></li>
    <li><a href="/trips/france-2009/">France 2009</a></li>
  </ul>
  <h3>
    Tags
  </h3>
  <ul>
    <li><a href="/favourites/">Favourites</a></li>
    <li><a href="/published/">Published</a></li>
    <li><a href="/bmx/">BMX</a></li>
    <li><a href="/tags/">All tags&hellip;</a></li>
  </ul>
  <h3>
    Years
  </h3>
<?php
  $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
?>
    <ul>
<?php
  foreach($years as $year) {
?>
      <li><a href="/<?php echo $year?>/"><?php echo $year?></a></li>
<?php
  }
?>
    </ul>
    <p>
      Send emails to <a href="mailto:me@quis.cc">me@quis.cc</a> or contact <a href="//twitter.com/quis">@quis</a> on Twitter
    </p>
</nav>
