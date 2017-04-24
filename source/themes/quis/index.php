<?php

  get_header();

  global $query_string;
  $query_modifications = is_category() ? "" : "&cat=-7"; // Exclude hidden posts unless on a category page
  $query_modifications .= parent_category_is("trips") ? "&order=ASC" : "";
  query_posts($query_string.$query_modifications);

  is_front_page() && !is_paged() ? require("nav.php") : null;

  if (have_posts()) {

    while (have_posts()) {

      the_post();
      require(in_category("words") ? "text.php" : "image.php");

    }

  } else {

    require("404.php");

  }

  get_footer();

?>
