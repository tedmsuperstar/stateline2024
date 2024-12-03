<?php
/**
 * State-Made header
 *
 * This is the template that displays all of the <head> section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package deals
 */

?><!DOCTYPE html>


<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<title><?=get_bloginfo( 'name' )?> | <?=get_the_title()?> </title>
<?php wp_head(); ?>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9XK59TQRE2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9XK59TQRE2');
</script>
<body <?php body_class(); ?>>
<header>
	<div class="nav-chrome">
  <a class = "logo" href="/">State Line</a>
  <div id="portalBurgerNav"></div>
    
    <div id="portalHeaderSearchBox"></div>
  </div>
	<?php
	
	wp_nav_menu( array( 'menu' => 'main-menu', 'theme_location' => '__no_such_location',
    // do not fall back to wp_page_menu()
    'fallback_cb' => false) );
	?>
</header>

<div id="content-wrap">


	