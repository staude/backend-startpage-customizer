<?php

/*  Copyright 2012  Frank Staude  (email : frank@staude.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class backend_startpage_customizer {
    
    /**
     * Constructor
     * 
     * Register all actions and filters
     */
    function __construct() {
        add_action( 'profile_personal_options', array( 'backend_startpage_customizer', 'user_startpage_option' ) );
        add_action( 'personal_options_update',  array( 'backend_startpage_customizer', 'update_startpage_option' ) );
        add_action( 'edit_user_profile_update', array( 'backend_startpage_customizer', 'update_startpage_option' ) );
        add_action( 'plugins_loaded',           array( 'backend_startpage_customizer', 'load_translations' ) );
        add_filter( 'login_redirect',           array( 'backend_startpage_customizer', 'redirect_user' ) , 10, 3 );
    }
    
    /**
     * load the plugin textdomain
     * 
     * load the plugin textdomain with translations
     */
    function load_translations() {
        load_plugin_textdomain( 'backend-startpage-customizer', false, dirname( plugin_basename( __FILE__ )) . '/languages/'  ); 
    }
    
    /**
     * redirect user to this selected backend startpage
     * 
     * redirect a user the the page, selected as backend startpage
     * 
     * @param string $redirect_to
     * @param type $request
     * @param object $user
     * @return string
     */
    function redirect_user ($redirect_to, $request, $user ) {
        $backend_startpage = get_user_meta($user->ID, 'backend_startpage', true );
        if ($backend_startpage != '') {
            return ('wp-admin/'.$backend_startpage);
        }
        return $redirect_to;
    }
    
    /**
     * create the html for the user options page
     * 
     * creates the html to extend the users personal options with a selectbox for 
     * a user customized startpage
     * 
     * @global array $menu
     * @global array $submenu
     * @param object $user
     */
    function user_startpage_option($user) {
        global $menu, $submenu;
        
        $backend_startpage = get_user_meta( $user->ID, 'backend_startpage', true );
        ?>
        <table class="form-table">
             <tr>
                 <th><label for="backend_startpage"><?php _e('Startpage', 'backend-startpage-customizer'); ?></label></th>
                 <td>
                    <select name="backend_startpage" id="backend_startpage">
                    <?php foreach ( $menu as $menuentry ) { ?>
                        <?php if ($menuentry[0] != '') { ?>
                            <option value="<?php echo esc_attr( $menuentry[2] ); ?>"
                            <?php selected( $backend_startpage, $menuentry[2] ); ?>>
                            <?php echo esc_html( preg_replace("/<.*>/","", $menuentry[0]) ); ?>
                            </option>                            
                            <?php if ( is_array( $submenu[ $menuentry[ 2 ] ] ) ) { ?>
                                <?php foreach ( $submenu[ $menuentry[ 2 ] ] as $submenuentry ) { ?>
                                    <?php if ($submenuentry[0] != '') { ?>
                                        <option value="<?php echo esc_attr( $submenuentry[2] ); ?>"
                                        <?php selected( $backend_startpage, $submenuentry[2] ); ?>>
                                        - <?php echo esc_html( preg_replace("/<.*>/","", $submenuentry[0] ) ); ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </select>
                    <span class="description"><?php _e('Select your backend startpage.', 'backend-startpage-customizer'); ?></span>
                </td>
            </tr>
        </table>
        <?php
    }
   
    /**
     * Update the startpapge of a user
     * 
     * Saves the startpage of a user in the user_meta table with the key 'backend_startpage'
     * 
     * @param integer $user_id
     * @return void
     */
    function update_startpage_option( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) )
            return false;
        $startpage = ( $_POST['backend_startpage'] );
        update_user_meta ( $user_id, 'backend_startpage', $startpage );
    }
        
}
