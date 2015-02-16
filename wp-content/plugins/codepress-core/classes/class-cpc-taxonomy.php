<?php

class CPC_Taxonomy {

    protected $args;

    public function __construct() {
        add_filter( 'codepress_register_taxonomy_args', array( $this, 'setup_args' ) );
    }

    public function get_args() {
        return $this->args;
    }

	public function set_args( $args ) {
        $this->args = $args;

        return $this;
    }

	public function setup_args( $args ) {
		$this
			->set_args( $args )
			->set_labels();

		return $this->get_args();
	}

    /**
     * Set labels for the taxonomy
     *
     */
    public function set_labels() {

        if ( ! isset( $this->args['labels'] ) )
            return false;

        $labels = $this->args['labels'];

        if ( empty( $labels['name'] ) || empty( $labels['singular_name'] ) )
            return false;

        $this->args['labels'] += array(
            'search_items'          => sprintf( __( 'Search %s', 'codepress' ), $labels['name'] ),
            'all_items' 			=> sprintf( __( 'All %s', 'codepress' ), $labels['name'] ),
            'parent_item' 			=> sprintf( __( 'Parent %s', 'codepress' ), $labels['singular_name'] ),
            'parent_item_colon' 	=> sprintf( __( 'Parent %s:', 'codepress' ), $labels['singular_name'] ),
            'edit_item' 			=> sprintf( __( 'Edit %s', 'codepress' ), $labels['singular_name'] ),
            'update_item' 			=> sprintf( __( 'Update %s', 'codepress' ), $labels['singular_name'] ),
            'add_new_item' 			=> sprintf( __( 'Add New %s', 'codepress' ), $labels['singular_name'] ),
            'new_item_name' 		=> sprintf( __( 'New %s Name', 'codepress' ), $labels['singular_name'] ),
            'menu_name'             => $labels['name'],
        );

        if ( ! isset( $this->args['hierarchical'] ) || ! $this->args['hierarchical'] ) {
            $this->args['labels'] += array(
                'popular_items' 				=> sprintf( __( 'Popular %s', 'codepress' ), $labels['name'] ),
                'separate_items_with_commas' 	=> sprintf( __( 'Separate %s with commas', 'codepress' ), $labels['name'] ),
                'add_or_remove_items' 			=> sprintf( __( 'Add or remove %s', 'codepress' ), $labels['name'] ),
                'choose_from_most_used' 		=> sprintf( __( 'Choose from the most used %s', 'codepress' ), $labels['singular_name'] ),
            );
        }

        return $this;
    }
}