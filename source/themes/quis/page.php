<?php
  get_header();

  if (have_posts()) {
    while (have_posts()) {
      the_post();
?>
    <div class="blogPost">
      <?php the_content(); ?>

<?php
      if (is_page("tags")) {
?>
      <ul class="tagList">
        <?php
          wp_list_categories(
            array(
              "hierarchical"      => 1,
              "title_li"          => __(""),
              "show_count"        => 1,
              "depth"             => 0,
              "exclude"           => "1,2,6,7,9,10,11,19,72,100,104,148"
            )
          );
        ?>
      </ul>
      <ul class="tagList">
      <?php
        wp_get_archives(
          array(
            "type" => "yearly"
          )
        );
      ?>
      </ul>
      <ul class="tagList">
      <?php
        wp_get_archives(
          array(
            "type" => "monthly"
          )
        );
      ?>
      </ul>
      <ul class="tagList">
      <?php
        wp_get_archives(
          array(
            "type" => "daily"
          )
        );
      ?>
      </ul>
<?php
      }
?>

    </div>
<?php
    }
  }

  get_footer();

?>
