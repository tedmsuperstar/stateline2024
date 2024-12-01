<?php


 
if( !defined( 'ABSPATH' ) )
		exit;

/**
 * Register menus
 *
 *
 * @package state-made
 */

class Menus {

	const FOOTER_MENU = 'footer-menu';
	const MAIN_MENU = 'main-menu';


	public static function registerMenus()
	{
		
		register_nav_menu( Menus::FOOTER_MENU, __( 'Footer Menu' ) );
		register_nav_menu( Menus::MAIN_MENU, __( 'Main Menu' ) );
		register_nav_menu( "another-menu", __( 'Another Menu' ) );
		
	}

}

add_action( 'after_setup_theme', 'Menus::registerMenus' );
