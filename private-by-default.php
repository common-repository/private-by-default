<?php
/**
 * @package private-by-default
 * @version 1.0
 */
/*
Plugin Name: Private by Default
Plugin URI: http://wordpress.org/extend/plugins/private-by-default/
Description: Make all posts and pages private by default. Forked and fixed version of PrivatePostDefault.
Author: Antti Mattila
Version: 1.0
Author URI: http://rarelyneeded.com/
*/

function default_post_visibility() {
    global $post;

    if ( 'publish' == $post->post_status ) {
        $visibility = 'public';
        $visibility_trans = __( 'Public' );
    } elseif ( !empty( $post->post_password ) ) {
        $visibility = 'password';
        $visibility_trans = __( 'Password protected' );
    } elseif ( $post->post_type == 'post' && is_sticky( $post->ID ) ) {
        $visibility = 'public';
        $visibility_trans = __( 'Public, Sticky' );
    } else {
        $post->post_password = '';
        $visibility = 'private';
        $visibility_trans = __( 'Private' );
    } ?>

    <script type='text/javascript'>
        (function($) {
            try {
                $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
                $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
                $('#visibility-radio-<?php echo $visibility; ?>').attr('checked', true);
            } catch(e) {}
        })(jQuery);
    </script>
    <?php
}
add_action( 'post_submitbox_misc_actions' , 'default_post_visibility' );

?>
