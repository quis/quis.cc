<?php

  $isArticle = in_category("words");
  $postType = $isArticle ? "article" : "photo";
  $postTypeArticle = $isArticle ? "An " : "A ";
  $endTitle = " &ndash; quis.cc";
  $theTitle = get_the_title() == "" ? "Untitled" : get_the_title();

  if (is_home()) {

    $pageMeta["menuDescription"] = "Home page";
    $pageMeta["title"] = "quis.cc";
    $pageMeta["description"] = "Chris Hill-Scott’s photo blog.";

  } elseif (is_single()) {

    $pageMeta["menuDescription"] = $isArticle ? "Single post" : "Single image";
    $pageMeta["title"] = $theTitle.$endTitle;
    $pageMeta["description"] = $postTypeArticle.$postType." from Chris Hill-Scott's photo blog, quis.cc.";

  } elseif (is_page()) {

    $pageMeta["menuDescription"] = $theTitle;
    $pageMeta["title"] = $theTitle.$endTitle;
    $pageMeta["description"] = "Chris Hill-Scott's photo blog.";

  } elseif (is_category()) {

    $isArticle = is_category("words");
    $pageMeta["menuDescription"] = $isArticle ? "Articles" : single_cat_title("", false);
    $pageMeta["title"] = $isArticle ? "Articles, trip reports, and interviews".$endTitle : ucfirst(single_cat_title("", false))." photos".$endTitle;
    $pageMeta["description"] = $isArticle ? "Articles, trip reports, and interviews from Chris Hill-Scott's photo blog, quis.cc." : single_cat_title("", false)." photos from Chris Hill-Scott's blog, quis.cc. Adventures in an easy-to-browse format.";

  } elseif (is_year()) {

    $theTime = get_the_time("Y");
    $pageMeta["menuDescription"] = $theTime;
    $pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
    $pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's photo blog.";

  } elseif (is_month()) {

    $theTime = get_the_time("n/Y");
    $pageMeta["menuDescription"] = $theTime;
    $pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
    $pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's photo blog.";

  } elseif (is_day()) {

    $theTime = get_the_time("j/n/Y");
    $pageMeta["menuDescription"] = $theTime;
    $pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
    $pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's photo blog.";

  } elseif (is_search()) {

    $pageMeta["menuDescription"] = "";
    $pageMeta["title"] = $endTitle;
    $pageMeta["description"] = "";

  } elseif (is_404()) {

    $pageMeta["menuDescription"] = "Nothing to offer!";
    $pageMeta["title"] = "Page not found".$endTitle;
    $pageMeta["description"] = "Chris Hill-Scott's photo blog.";

  }

?>
