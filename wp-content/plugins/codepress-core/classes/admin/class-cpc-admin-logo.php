<?php

class CPC_Admin_Logo {

    public function __construct() {
        add_action( 'login_enqueue_scripts', array( $this, 'display' ) );
    }

    /**
     * Change the title for logo on the login screen
     *
     */
    public function headertitle() {
        return get_bloginfo( 'title' );
    }

    /**
     * Change the url for logo on the login screen
     *
     */
    public function headerurl() {
        return get_bloginfo( 'url' );
    }

    /**
     *	Login logo
     *
     */
    public function display() {
        $uri = apply_filters( 'codepress_login_logo_uri', false );

        if ( $uri ) {
            add_filter( 'login_headerurl', array( $this, 'headerurl' ) );
            add_filter( 'login_headertitle', array( $this, 'headertitle' ) );

            $padding = apply_filters( 'codepress_login_logo_padding', '35' );

            echo "
                <style>
                    #login h1 a {
                        background-image: url({$uri});
                        background-size: auto;
                        padding-bottom: {$padding}px;
                    }
                </style>
            ";
        }
    }
}

