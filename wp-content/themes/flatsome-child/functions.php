<?php
// Add custom Theme Functions here

add_filter('use_block_editor_for_post', '__return_false');
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );