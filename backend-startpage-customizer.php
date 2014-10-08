<?php
/*
Plugin Name: Backend Startpage Customizer
Plugin URI: http://www.staude.net/wordpress/plugins/BackendStartpageCustomizer
Description: Redirect the user after login to a predetermined site in the backend. 
Author: Frank Staude
Version: 0.5
Author URI: http://www.staude.net/
Compatibility: WordPress 4.0
Text Domain: backend-startpage-customizer
Domain Path: languages

/*  Copyright 2012-2014  Frank Staude  (email : frank@staude.net)

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

if (!class_exists( 'backend_startpage_customizer' ) ) {

    include_once dirname( __FILE__ ) .'/class-backend-startpage-customizer.php';

    /**
     * Delete startpage metavalue from Usermeta for all Users.
     */
    function backend_startpage_customizer_uninstall() {
        global $wpdb;
        $wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'backend_startpage';" );
    }

    register_uninstall_hook( __FILE__,  'backend_startpage_customizer_uninstall' );

    $backend_startpage_customizer = new backend_startpage_customizer();

}
