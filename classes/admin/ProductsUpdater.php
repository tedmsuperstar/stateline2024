<?php

if( !defined( 'ABSPATH' ) )
		exit;
/**
 * Admin screen updater for push-button pulling in the latest navigation from the parent site. CUrrently all sites use this, but in the past we have also supported a "custom" navigation that doesn't match the parent site. THus the on-denamd nature of the feature.
 *
 *
 * @package statemade
 */
class ProductsUpdater {

	//register a submenu page for displaying help
	public static function registerPage(){
		
		add_submenu_page(
				'tools.php',
				'Products Updater', /*page title*/
				'Products Updater', /*menu title*/
				'edit_posts', /*roles and capability needed*/
				'products_updater',
				'ProductsUpdater::showPage' /*replace with your own function*/
		);
	}


	public static function showPage() {

			?>
		<div id="poststuff" class="wrap">
            <script>
                window.spreadsheetId='<?=get_field("products_google_sheet_id", "option")?>';
                window.apiKey='<?=get_field("google_sheets_api_key", "option")?>';
            </script>
			<h1>Products Updater</h1>
            <script>window.productsUpdaterNonce = "<?=wp_create_nonce( 'wp_rest' );?>";</script>
			<div class="postbox " style="padding:20px;" >
        			<div class="instructions">
					<h2>Press the button to update products.<br>
						Sheet URL: https://docs.google.com/spreadsheets/d/.<?=get_field("products_google_sheet_id", "option")?>."/edit?gid=0#gid=0<br> 
						API Key: <?=get_field("google_sheets_api_key", "option")?><br> 
						Don't navigate away from this page until it finished.</h2>
					
					<div class="inside">
						<div>
						<input id="products-updater-button" type = "button" value = "Update">
                        <div id="products-updater-status" style="padding:10px;"></div>
                            <table id="products-updater-table" style="display:none;" class="wp-list-table widefat fixed striped table-view-list">
                                <tr>
                                    <th>Name</th>
                                    <th>Success</th>
                                </tr>
                            </table>
						</div>

					</div>
				
			
				
				
				
				</div>
			</div>

		

		<?php 
	} 

}

add_action('admin_menu', 'ProductsUpdater::registerPage');
