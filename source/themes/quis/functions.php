<?php

  function makeDateLink($timestamp) {

    $displayedDate = explode(" ", date("Y n j", $timestamp));
    $linkDate = explode(" ", date("Y m d", $timestamp));
?>

        <a href="/<?php echo $linkDate[0]?>&#8202;/&#8202;<?php echo $linkDate[1]?>&#8202;/&#8202;<?php echo $linkDate[2]?>"><?php echo $displayedDate[2]?></a>&#8202;/&#8202;<a href="/<?php echo $linkDate[0]?>/<?php echo $linkDate[1]?>"><?php echo $displayedDate[1]?></a>/<a href="/<?php echo $linkDate[0]?>"><?php echo $displayedDate[0]?></a>
<?php

  }


  // List camera data
  function getExif($img) {

    if (!function_exists("exif_read_data")) return "";

    $exif = exif_read_data($img);

    while (list($key,$value) = each($exif)) {

      $picture[$key] = $value;

    }

    if ($picture["ExposureTime"]) {

      // Date
      $longdate = explode(" ", $picture["DateTimeOriginal"]);
      $longdate = explode(":", $longdate[0]);
      $timestamp = mktime(1, 1, 1, $longdate[1], $longdate[2], $longdate[0]);

      // MF or AF lens
      if (formatExif($picture["MaxApertureValue"]) < 1) {

        $focalLength = suffixes($img, 50);

      } else {

        $focalLength = formatExif($picture["FocalLength"]);
        $aperture = formatExif($picture["FNumber"]);

      }

      // Exposure
      $exposureTime = formatExif($picture["ExposureTime"]);
      $ISO = $picture["ISOSpeedRatings"];

    } else {

      $legacy = suffixes($img);

    }

    return $timestamp.",".$focalLength.",".$aperture.",".$exposureTime.",".$ISO.",".$legacy;

  }

  function suffixes(
    $img,
    $default = "With an unknown camera ",
    $suffixes = array (
      "_8" => 8,
      "_PC" => 35,
      "_100" => 100,
      "_200" => 200,
      "_ak" => "With an Agfa Karat IV at 50mm",
      "_c220" => "With a Mamiya C220 at 80mm",
      "_fg" => "With a Nikon FG",
      "_pola" => "With a Mamiya RB67",
      "_ym" => "With a Yashicamat at 80mm",
      "_disposable" => "With a disposable camera",
      "_t2" => "With a Contax T2 at 38mm",
      "_x300" => "With a Minolta X-300",
    )
  ) {

    foreach ($suffixes as $suffix => $output) {
      if (stristr($img, $suffix)) {
        return $output;
      }
    }

    return $default;

  }

  function formatExif($snippet) {

    $snippet = explode("/", $snippet);

    if (!isSet($snippet[1])) return $snippet;

    return $snippet[0] / $snippet[1];

  }

  // Post category listing with support for exclusion
  function the_category_exclude($separator, $excluded = array("")) {

    foreach (get_the_category() as $category) {
      if (in_array($category->cat_name, $excluded)) {
        $output[] = '<a href="' . get_category_link($category->term_id) . '" title="View all posts tagged ' . $category->name . '">' . $category->name . '</a>';
      }
    }

    return implode($separator, $output);

  }

  function the_category_include($separator, $included = array(""), $output = array()) {

        $categories = get_the_category();

        foreach ($included as $inc) {

            foreach ($categories as $category) {

                $parent = get_category($category->category_parent);

                if ($parent->cat_name == $inc) {
                    $output[] = '<a href="' . get_category_link($category->term_id) . '" class="tag-link" title="View all posts tagged ' . $category->name . '">' . $category->name . '</a>';
                }

            }

        }

    return implode($separator, $output);

  }


  function parent_category_is($slug) {

    $category = get_category(get_query_var("cat"));
    $categoryFromSlug = get_category_by_slug($slug);

    if ($category->category_parent == $categoryFromSlug->term_id) {
      return true;
    }

    return false;

  }

?>
