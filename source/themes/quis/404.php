<?php
	// Check content is found
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	get_header();
?>

<div class="blogPost">
	<h2>
		You tried visiting
		http://quis.cc<?php echo $_SERVER["REQUEST_URI"] ?>
		and it doesn't exist
	</h2>
	<p>
		Sorry about that. Here are some things you can try:
	</p>
	<ul>
		<li>
			Browsing other photos on this site. You might like to
			start with
			<a href="/tags/favourites">the favourites tag</a>,
			<a href="/tags/bmx">the BMX tag</a>,
			or <a href="/">the homepage</a>.
		</li>
		<li>
			Letting me know about the problem by
			<a href="mailto:me@quis.cc" title="me@quis.cc">emailing me</a>.
		</li>
	</ul>
	<p>
		Failing all that, here's a random photo from the archives:
	</p>
</div>

<?php
	query_posts(
		array(
			"orderby" => "rand",
			"cat" => "-308, -286",
			"showposts" => 1,
		)
	);

	if (have_posts()) {

		while (have_posts()) {

			the_post();
			require("image.php");

		}

	}

    get_footer();

?>
