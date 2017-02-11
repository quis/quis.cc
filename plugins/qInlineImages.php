<?php

	/*
		Plugin Name: quis.cc inline images
		Plugin URI: http://quis.cc
		Description: Inline image posting for quis.cc
		Version: 0.1
		Author: Chris Hill-Scott
		Author URI: http://quis.cc
		License: GPL2
	*/

	// Hook into Wordpress
	add_filter("the_content", "qImage");

	// Function to filter posts
	function qImage($postContent) {

		// Buffer content so that function can return it
		ob_start();

		// This variable is used in the page template to generate correct permalinks
		$parentPost = true;

		// Search post for [[ post id as int ]]
		foreach (
			explode("\n", $postContent)
			as $line
		) {

			if (preg_match("/\[\[(\d*)\]\]/", $line, $matches)) {

				// Retrieve post and set up for image template
				global $post;
				$holdingPost = $post;

				foreach (
					get_posts("p=".$matches[1]."&post_status=any")
					as $post
				) {

					setup_postdata($post);
					require(TEMPLATEPATH."/image.php");

				}

				$post = $holdingPost;

			} else {

				// Pass output through if special syntax not found
				echo $line;

			}

		}

		// Return buffered contents
		$output = ob_get_contents();
		ob_end_clean();
		$parentPost = false;
		return $output;

	}

?>