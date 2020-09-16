<?php 
class HK_Category_Image_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( false, __( '[HK] - Hiển thị chuyên mục với hình ảnh' ) );
    }
    function widget($args, $instance) {
        extract( $args );
        $title      = $instance['title'];
        if ( !defined('ABSPATH') )
        die('-1');
        echo $before_widget; 
        echo $before_title.$title.$after_title; ?>
        <div class="list-category-widget">
            <ul>
               <?php $args = array( 
				    'hide_empty' => 0,
				    'taxonomy' => 'product_cat',
				    'parent' => 0
				    ); 
				    $cates = get_categories( $args ); 
				    foreach ( $cates as $cate ) {  ?>
				    	<?php 
				    		$thumbnail_id = get_term_meta( $cate->term_id, 'thumbnail_id', true );
				    		$image = wp_get_attachment_url( $thumbnail_id ); 
				    	?>
							<li>
								<a href="<?php echo get_term_link($cate->slug, 'product_cat'); ?>">
									<img src="<?php echo $image; ?>" alt="<?php echo $cate->name; ?>">
								</a>
								<h4>
									<a href="<?php echo get_term_link($cate->slug, 'product_cat'); ?>"><?php echo $cate->name; ?></a>
								</h4>
							</li>
				<?php } ?>
            </ul>
        </div>
    <?php echo $after_widget;
    } 
    function update($new_instance, $old_instance) {
        $instance['title']  = strip_tags($new_instance['title']);
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => 'Tiêu đề',
        );
        $instance = wp_parse_args((array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Nhập tiêu đề: '); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>"  />
        </p>
    <?php }
}
 
function hkplugin_register_widgets() {
    register_widget( 'HK_Category_Image_Widget' );
}
add_action( 'widgets_init', 'hkplugin_register_widgets' );