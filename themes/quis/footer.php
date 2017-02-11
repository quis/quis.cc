    </div>

    <footer>
      <span class="next-link">
        <?php next_posts_link("Next page"); ?>
      </span>
      <?php require("nav.php"); ?>
    </footer>

    <?php require("scripts.php") ?>

  </body>
</html>

<!--
  <?php echo get_num_queries() ?> SQL queries done.
  Page generation took <?php echo timer_stop() ?> seconds.
-->
