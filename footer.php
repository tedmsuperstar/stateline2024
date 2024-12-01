</div>
<footer>
<div class="nav-chrome"><a class = "logo" href="/">State Line</a></div>
	<?php
	wp_nav_menu( array( 'menu' => 'footer-menu', 'theme_location' => '__no_such_location',
    // do not fall back to wp_page_menu()
    'fallback_cb' => false) );
	?>
</footer>
<?php wp_footer(); ?>
</body>
</html>