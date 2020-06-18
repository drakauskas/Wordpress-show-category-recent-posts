
add_action( 'init', 'create_custom_shortcode' );
/**
 * Registers the shortcode with add_shortcode so WP knows about it.
 */ 
function create_custom_shortcode()
{
    add_shortcode( 'show_category_posts', 'recent_posts_of_category' );
}

/**
 * The call back function for the shortcode. Returns current post category recent list of posts.
 */
function recent_posts_of_category( $args )
{
    global $post;
    $postcat = get_the_category( $post->ID );
   
   /* For modification reasons 
       echo "<pre>";
      print_r($postcat);
      echo "</pre>";
    */
    $current_category = wp_list_pluck( $postcat, 'term_id' );

    $posts = get_posts(
        array(
            'numberposts'   => 4,
            'category' => $current_category
        )
    );


    if( empty( $posts ) ) return '';

    $recent_posts = '<ul>';
    foreach( $posts as $post )
    {
        $recent_posts .= sprintf(
            '<li><a href="%s" title="%s">%s</a></li>',
            get_permalink( $post ),
            esc_attr( $post->post_title ),
            esc_html( $post->post_title )
        );
    }
    $recent_posts .= '</ul>';
    return $recent_posts;
}
