<?php

  $publicImageBucket = "//images.quis.cc/";
  $internalImageBucket = "https://images.quis.cc/";

  list($image, $notes) = explode("\n", get_the_content());
  $filename = trim($image).".jpg";
  $image = $internalImageBucket.$filename;
  $currentImagePost = get_the_ID();

  $cachedWidth = get_post_meta($currentImagePost, "imageWidth", true);
  $cachedHeight = get_post_meta($currentImagePost, "imageHeight", true);
  $cachedExif = get_post_meta($currentImagePost, "imageEXIF", true);
  $routeTo = get_post_meta($currentImagePost, "route-to", true);

  $imgClass = stristr($image, "_static") ? " static" : "";

  if (
    $cachedWidth   > 0 &&
    $cachedHeight  > 0 &&
    $cachedExif   != ""
  ) {

    $width = $cachedWidth;
    $height = $cachedHeight;
    $exif = $cachedExif;

  } else {

    list($width, $height) = getimagesize($image);
    $exif = getExif($image);

    if ($width && $height) {
      add_post_meta($currentImagePost, "imageWidth", $width, true);
      add_post_meta($currentImagePost, "imageHeight", $height, true);
      add_post_meta($currentImagePost, "imageEXIF", $exif, true);
    }

  }

  list($timestamp, $focalLength, $aperture, $exposureTime, $ISO, $legacy) = explode(",", $exif);

  $permalink = get_permalink();
  $slug = basename($permalink);

  $parentID = get_post_meta($post->ID, "parent", true);

  if ("" != $parentID) {
    $parentTitle = get_the_title($parentID);
    $parentLink = get_permalink($parentID);
    $permalink = in_category("hidden") ? $parentLink."#post-".get_the_ID() : $permalink;
  }

?>

      <div
        class="hasTooltip mask<?php echo $parentPost ? "" : " unit";?><?php echo "" == $routeTo ? "" : " onMap";?><?php echo $imgClass?>"
        id="post-<?php echo get_the_ID() ?>"
      >
<?php
  global $is_first_image
?>

        <img
          src="<?php echo $publicImageBucket ?><?php echo $filename ?>" width="<?php echo $width?>" height="<?php echo $height?>"
          alt="<?php echo ("" == get_the_title()) ? "Untitled" : get_the_title() ?>"
          loading="<?php echo $is_first_image == true ? "eager" : "lazy" ?>"
        />

<?php
  $is_first_image = false;
?>

        <h2>
            <a href="<?php echo $permalink ?>">
<?php
  if ("" == get_the_title()) {
?>
                Untitled
<?php
    } else {
?>
              <?php echo get_the_title() ?>
<?php
    }
?>
            </a>
        </h2>
                <p>
                    <?php
                        echo the_category_include(
                            " ",
                            array(
                              "people",
                              "stunts",
                              "places",
                              "trip",
                            )
                        );
                    ?>
<?php
  if ($exif != "") {
    if ($legacy == "") {
?>
                    <time datetime="<?php echo date(DATE_W3C, $timestamp) ?>"><?php echo date("j", $timestamp)?>&#8202;/&#8202;<?php echo date("n", $timestamp)?>&#8202;/&#8202;<?php echo date("Y", $timestamp)?></time>
<?php
    }
  }
?>
                </p>
<?php
  if ("" != $notes) {
?>
                <p>
                  <?php echo  $notes; ?>
                </p>
<?php
  }

  if (
    $parentID &&
    !$parentPost
  ) {
?>
                <p>
                    Part of the article <a href="<?php echo $parentLink?>"><?php echo $parentTitle?></a>
                </p>
<?php
  }
?>

      </div>
