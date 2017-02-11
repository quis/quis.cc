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
  Generated <?php echo date('Y-m-d H:i:s') ?>
  Took <?php echo timer_stop() ?> seconds.
  Using <?php echo get_num_queries() ?> SQL queries.
-->
