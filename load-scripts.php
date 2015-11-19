<?php

//load scripts
add_action( 'wp_enqueue_scripts','baw_load_scripts' );

function baw_load_scripts() {

	wp_register_script( 'baw-script',plugins_url( '/baw-script.min.js', __FILE__ ), array( 'jquery' ), BAW_VERSION, true );
	wp_enqueue_script( 'baw-script' );

}
