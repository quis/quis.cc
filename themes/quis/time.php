<?php

	$isArticle = in_category("words");
	$postType = $isArticle ? "article" : "photo";
	$postTypeArticle = $isArticle ? "An " : "A ";
	$endTitle = " &ndash; quis.cc";
	$theTitle = get_the_title() == "" ? "Untitled" : get_the_title();

	if (is_home()) {

		$pageMeta["menuDescription"] = "All photos &amp; articles";
		$pageMeta["title"] = "quis.cc &ndash; adventure photography &amp; journalism";
		$pageMeta["description"] = "Adventures from Chris Hill-Scott’s blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_single()) {

		$pageMeta["menuDescription"] = true ? "" : $theTitle;
		$pageMeta["title"] = $theTitle.$endTitle;
		$pageMeta["description"] = $postTypeArticle.$postType." from Chris Hill-Scott's blog, quis.cc. Adventures in an easy-to-browse format.";

	} elseif (is_page()) {

		$pageMeta["menuDescription"] = $theTitle;
		$pageMeta["title"] = $theTitle.$endTitle;
		$pageMeta["description"] = "Adventures from Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_category()) {

		$isArticle = is_category("words");
		$pageMeta["menuDescription"] = $isArticle ? "Articles" : "Photos &amp; articles tagged &ldquo;".single_cat_title("", false)."&rdquo;";
		$pageMeta["title"] = $isArticle ? "BMX articles &amp; interviews".$endTitle : ucfirst(single_cat_title("", false))." photos".$endTitle;
		$pageMeta["description"] = $isArticle ? "Articles and interviews from Chris Hill-Scott's blog, quis.cc. Adventures in an easy-to-browse format." : single_cat_title("", false)." photos from Chris Hill-Scott's blog, quis.cc. Adventures in an easy-to-browse format.";

	} elseif (is_year()) {

		$theTime = get_the_time("Y");
		$pageMeta["menuDescription"] = "Photos &amp; articles from ".$theTime;
		$pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
		$pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_month()) {

		$theTime = get_the_time("F Y");
		$pageMeta["menuDescription"] = "Photos &amp; articles from ".$theTime;
		$pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
		$pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_day()) {

		$theTime = get_the_time("jS F Y");
		$pageMeta["menuDescription"] = "Photos &amp; articles from ".get_the_time("j")."<span class='above'>".get_the_time("S")."</span>".get_the_time(" F Y");
		$pageMeta["title"] = $theTime." &ndash; photos and articles".$endTitle;
		$pageMeta["description"] = "Articles and photos from ".$theTime." on Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_search()) {

		$pageMeta["menuDescription"] = "Search results for &ldquo;".get_search_query()."&rdquo;";
		$pageMeta["title"] = "&ldquo;".get_search_query()."&rdquo; &ndash; search results".$endTitle;
		$pageMeta["description"] = "Adventures from Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	} elseif (is_404()) {

		$pageMeta["menuDescription"] = "Nothing to offer!";
		$pageMeta["title"] = "Page not found".$endTitle;
		$pageMeta["description"] = "Adventures from Chris Hill-Scott's blog. 1500+ photos in an easy-to-browse format.";

	}

?>
