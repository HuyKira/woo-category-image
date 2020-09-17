<?php 
class HK_Category_Image_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( false, __( '[HK] - Hiển thị chuyên mục với hình ảnh' ) );
    }
    function widget($args, $instance) {
        extract( $args );
        $title      = $instance['title'];
        $exculde    = $instance['exculde'];
        $arrayId    = array();
        if($exculde){
            $arrayId    = explode(",", $exculde);
        }
        $isavatar = $instance[ 'isavatar' ] ? false : true;
        $child = $instance[ 'child' ] ? false : true;
        $showcount = $instance[ 'showcount' ] ? true : false;
        if ( !defined('ABSPATH') )
        die('-1');
        echo $before_widget; 
        echo $before_title.$title.$after_title; ?>
        <div class="list-category-widget">
            <ul>
                <?php $args = array( 
				    'hide_empty' => 0,
				    'taxonomy' => 'product_cat',
                    'exclude'  => $arrayId,
				    'parent' => 0
				    ); 
				    $cates = get_categories( $args ); 
				    foreach ( $cates as $cate ) {  ?>
				    	<?php 
				    		$thumbnail_id = get_term_meta( $cate->term_id, 'thumbnail_id', true );
				    		$image = wp_get_attachment_url( $thumbnail_id );
                            $parent = $cate->term_id;
                            $count = '';
                            if($showcount){
                                $count = '<span> ('.$cate->count.')</span>';
                            }
				    	?>
							<li>
                                <?php if($isavatar){ ?>
    								<a href="<?php echo get_term_link($cate->slug, 'product_cat'); ?>">
    									<img src="<?php echo $image; ?>" alt="<?php echo $cate->name; ?>">
    								</a>
                                <?php } ?>
								<h4>
									<a href="<?php echo get_term_link($cate->slug, 'product_cat'); ?>"><?php echo $cate->name; echo $count; ?></a>
								</h4>
                                <?php if($child){ ?>
                                    <?php 
                                        $args_child = array(  'hide_empty' => 0, 'taxonomy' => 'product_cat', 'parent' => $parent );
                                        $cates_child = get_categories( $args_child );
                                        if($cates_child && count($cates_child) > 0){
                                    ?>
                                    <div class="icon-show"></div>
                                    <ul>
                                        <?php 
                                            foreach ($cates_child as $key => $value) { 
                                            $count_child = '';
                                            if($showcount){
                                                $count_child = '<span> ('.$value->count.')</span>';
                                            }
                                        ?>
                                            <li><a href="<?php echo get_term_link($value->slug, 'product_cat'); ?>"><?php echo $value->name; echo $count_child; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                <?php } ?>
							</li>
				<?php } ?>
            </ul>
        </div>
    <?php echo $after_widget;
    } 
    function update($new_instance, $old_instance) {
        $instance['title']  = strip_tags($new_instance['title']);
        $instance['exculde']  = strip_tags($new_instance['exculde']);
        $instance[ 'isavatar' ] = $new_instance[ 'isavatar' ];
        $instance[ 'child' ] = $new_instance[ 'child' ];
        $instance[ 'showcount' ] = $new_instance[ 'showcount' ];
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => 'Tiêu đề',
        );
        $instance = wp_parse_args((array) $instance, $defaults ); ?>
        <style>
            .group-data{
                margin-top: 10px;
            }
            .checkbox-data{
                margin-bottom: 10px;
            }
        </style>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Nhập tiêu đề: '); ?></strong></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('exculde'); ?>"><strong><?php _e('Loại bỏ danh mục '); ?></strong></label><br>
            <i>Bạn có thể loại bỏ các danh mục không muốn hiện thị bằng cách nhập các id của chuyên mục đó vào đây, cách nhau bằng 1 dấu phẩy</i>
            <input class="widefat" id="<?php echo $this->get_field_id('exculde'); ?>" name="<?php echo $this->get_field_name('exculde'); ?>" type="text" value="<?php echo $instance['exculde']; ?>"  />
        </p>
        <div class="checkbox-data">
            <label><strong>Ẩn hiện các chức năng:</strong></label><br>
            <div class="group-data">
                <input type="checkbox" name="<?php echo $this->get_field_name('isavatar'); ?>" <?php checked( $instance[ 'isavatar' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'isavatar' ) ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'isavatar' ) ); ?>">Ẩn ảnh đại diện</label>
            </div>
            <div class="group-data">
                <input type="checkbox" name="<?php echo $this->get_field_name('child'); ?>" <?php checked( $instance[ 'child' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'child' ) ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'child' ) ); ?>">Ẩn danh mục con</label>
            </div>
            <div class="group-data">
                <input type="checkbox" name="<?php echo $this->get_field_name('showcount'); ?>" <?php checked( $instance[ 'showcount' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'showcount' ) ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'showcount' ) ); ?>">Hiện số lượng sản phẩm</label>
            </div>
        </div>
    <?php }
}
 
function hkplugin_register_widgets() {
    register_widget( 'HK_Category_Image_Widget' );
}
add_action( 'widgets_init', 'hkplugin_register_widgets' );