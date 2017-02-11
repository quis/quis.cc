<?php
	get_header();

	if (have_posts()) {
		while (have_posts()) {
			the_post();
?>
		<div class="page">
			<?php the_content(); ?>

<?php
			if (is_page("tags")) {
?>
			<ul class="tags">
				<?php
					wp_list_categories(
						array(
							"hierarchical"      => 1,
							"title_li"          => __(""),
							"show_count"        => 1,
							"depth"             => 0,
							"exclude"           => "1"
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
