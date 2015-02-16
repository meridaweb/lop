<?php

class CPC_Admin_Dashboard {

    function __construct() {
        add_action( 'admin_init', array( $this, 'hide_widgets_installed_user' ) );
        add_action( 'user_register', array( $this, 'hide_widgets' ) );
    }

    /**
     * Runs hide_widgets() for first users
     *
     */
    function hide_widgets_installed_user() {
        $user_id = get_current_user_id();

        if ( ! get_user_meta( $user_id, 'codepress_hide_dashbord_widgets', true ) ) {
            update_user_meta( $user_id, 'codepress_hide_dashbord_widgets', 1 );
            $this->hide_widgets( $user_id );
        }
    }

    /**
     * Hide dasbbord widgets and set layout
     *
     * @param int $user_id
     */
    function hide_widgets( $user_id ) {
        $hide = array(
            'dashboard_incoming_links',
            'dashboard_plugins',
            'dashboard_quick_press',
            'dashboard_recent_drafts',
            'dashboard_primary',
            'dashboard_secondary',
        );

        update_user_meta( $user_id, 'metaboxhidden_dashboard', apply_filters( 'codepress_hide_dashbord_widgets', $hide, $user_id ) );
        update_user_meta( $user_id, 'screen_layout_dashboard', 1 );
    }

}