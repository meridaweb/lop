<?php

class CPC_Posttype {

	protected $args;

	/**
	 * Default menu position
	 *
	 * @var integer
	 */
	static $menu_position = 32;

    public function __construct() {
        add_filter( 'codepress_register_post_type_args', array( $this, 'setup_args' ) );
    }

    public function get_args() {
        return $this->args;
    }

	public function set_args( $args ) {
		$this->args = $args;

		return $this;
	}

	public function setup_args( $args ) {
        if ( ! isset( $args['menu_position'] ) )
			$args['menu_position'] = self::$menu_position++;

		$this
			->set_args( $args )
			->set_labels();

		return $this->get_args();
	}

    /**
     * Set default labels for post type
     *
     */
    public function set_labels() {
        if ( ! isset( $this->args['labels'] ) )
            return false;

        $labels = $this->args['labels'];

        if ( empty( $labels['name'] ) || empty( $labels['singular_name'] ) )
            return false;

        $this->args['labels'] += array(
            'add_new'              	=> sprintf( __( 'New %s', 'codepress' ), $labels['singular_name'] ),
            'add_new_item'        	=> sprintf( __( 'Add %s', 'codepress' ), $labels['singular_name'] ),
            'edit_item'             => sprintf( __( 'Edit %s', 'codepress' ), $labels['singular_name'] ),
            'new_item'            	=> sprintf( __( 'Add %s', 'codepress' ), $labels['singular_name'] ),
            'view_item'             => sprintf( __( 'View %s', 'codepress' ), $labels['singular_name' ] ),
            'search_items'        	=> sprintf( __( 'Search %s', 'codepress' ), $labels['singular_name'] ),
            'not_found'             => sprintf( __( 'No %s found', 'codepress' ), $labels['singular_name'] ),
            'not_found_in_trash'    => sprintf( __( 'No %s found in trash', 'codepress' ), $labels['singular_name'] ),
            'parent_item_colin'     => '',
            'menu_name'             => $labels['name'],
        );

        return $this;
    }
}