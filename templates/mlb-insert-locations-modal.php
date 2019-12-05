<style>
  .wp-media-buttons .mlb_add_locations span.wp-media-buttons-icon:before {
    font: 400 18px/1 dashicons;
    speak: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    content: '\f231';
  }

  .location-item,
  .location-item:focus {
    border-radius: 2px;
    box-shadow: none;
    display: inline-block;
    margin-right: 35px;
    padding: 2px;
    text-align: center;
    text-decoration: none;
    width: 150px;
  }

  .location-item.selected,
  .location-item.selected:focus {
    background: #0073aa;
    color: #fff;
  }

  .insert-all-locations {
    float: left;
  }

  .insert-selected-locations {
    float: right;
  }
</style>

<div id="mlb-select-locations" style="display: none;">
  <div>
    <div class="staff-posts">
      <p>
        <a href="#" class="button-primary insert-all-locations">Insert All Locations</a>

        <a href="#" class="button-primary insert-selected-locations" style="display: none;">Insert Selected Locations</a>
      </p>
      <p style="clear: both;">Or select locations below</p>
      <?php
      $business_ids = get_option('mlb_business_id');

      if (!is_array($business_ids)) {
        $business_ids = array($business_ids);
      }

      foreach($business_ids as $id) :
        ?>

        <a href="#" data-location-id="<?php echo $id; ?>" class="location-item">
          <strong><?php echo do_shortcode("[business-name location={$id}]"); ?></strong><br />
          <?php echo do_shortcode("[address location={$id}]"); ?><br />
          <?php echo do_shortcode("[city location={$id}]"); ?>, <?php echo do_shortcode("[state location={$id}]"); ?> <?php echo do_shortcode("[zip location={$id}]"); ?><br />
          <?php echo do_shortcode("[phone-number location={$id}]"); ?>
        </a>


        <?php
      endforeach;
      ?>
    </div>
  </div>
</div>
<a href="#" id="mlb-insert-locations" class="button mlb_add_locations"><span class="wp-media-buttons-icon"></span> Add Locations</a>