<?php

  header("Content-Type: text/html; charset=UTF-8");

  require("time.php");

?>
<!DOCTYPE html>
<html lang="en-GB">
  <head>
    <title><?php echo $pageMeta["title"]?></title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Tinos" rel="stylesheet">
    <link rel="stylesheet" href="/wp-content/themes/quis/css/quis.css">
    <link rel="alternate" type="application/rss+xml" title="quis.cc RSS feed" href="/feed/">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <meta name="description" content="<?php echo $pageMeta["description"]?>" />
  </head>
  <body>
    <header>
      <h1>
        <span><?php echo $pageMeta["menuDescription"] ?></span>
        <a title="Home page" href="/">Chris Hill-Scott’s photo blog</a>
      </h1>
    </header>
    <div id="photos">
