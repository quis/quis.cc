<?php
  $slug = basename(get_permalink());
?>
      <div class="blogPost unit" id="post-<?php echo $slug ?>">

        <div class="mask">
          <h2>
            <a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a>
          </h2>

          <p class="meta">
            <?php makeDateLink(get_the_time("U")) ?>
            &ensp;
                      <?php
                          echo the_category_include(
                              " &ensp; ",
                              array(
                                  "people",
                                  "trip",
                              )
                          );
                      ?>
          </p>
        </div>

        <?php the_content(); ?>

        <p class="center">
          &mdash;
        </p>

      </div>
