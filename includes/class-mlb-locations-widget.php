<?php

class MLB_Locations_Widget extends WP_Widget {
  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'MLB_Locations_Widget', // Base ID
      __('Locations Widget', 'text_domain'), // Name
      array( 'description' => __( 'Display business location information', 'text_domain' ), ) // Args
    );
  }

  public function register_widget() {
    register_widget( 'MLB_Locations_Widget' );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    // check for template in active theme
    $template = locate_template(array('mlb-locations-widget.php'));

    // if none found use the default template
    if ( $template == '' ) $template = plugin_dir_path( __FILE__ ) . '../templates/mlb-locations-widget.php';

    include ( $template );
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   * @return something
   */
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'Our Locations', 'text_domain' );
    }
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>


    <?php

    $locations_class = new MLB_LOCATIONS();
    $shortcodes_class = new MLB_Locations_Shortcodes($locations_class->get_plugin_name(), $locations_class->get_version());

    $business_ids = get_option('mlb_business_id');

    if (!is_array($business_ids)) {
      $business_ids = array($business_ids);
    }

    ?>

    <p>
      <label>Select Locations to Display
        <select class="widefat" id="<?php echo $this->get_field_id('locations'); ?>"
                name="<?php echo $this->get_field_name('locations'); ?>[]" required multiple>

          <?php
          $selected_locations = isset( $instance['locations'] ) ? $instance['locations'] : array();

          foreach($business_ids as $business_id) {
            $location = $shortcodes_class->get_business_details($business_id);
            $location = $location[0];
            $selected = in_array( $location['id'], $selected_locations ) ? ' selected="selected"' : '';
            echo '<option' . $selected . ' value="' . $location['id'] . '">' . $location['name'] . '</option>';
          }
          ?>

        </select>
      </label>
    </p>

      <!-- Display the multi-select for locations -->

    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();

    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['locations'] = $new_instance['locations'];

    return $instance;
  }
}