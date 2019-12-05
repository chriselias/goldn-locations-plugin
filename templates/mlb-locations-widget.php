<?php
$business_ids = array();
if (isset($instance['locations'])) {
  $business_ids = $instance['locations'];
}

if (isset($instance['title'])) : ?>
  <h2 class="mlb-staff-title"><?php echo $instance['title'] ?></h2>
<?php endif;

foreach($business_ids as $id) :
  ?>

  <h3><?php echo do_shortcode("[common-name location={$id}]"); ?></h3>

  <p>
    <?php echo do_shortcode("[address location={$id}]"); ?><br />
    <?php echo do_shortcode("[city location={$id}]"); ?>, <?php echo do_shortcode("[state location={$id}]"); ?> <?php echo do_shortcode("[zip location={$id}]"); ?><br />
    <?php echo do_shortcode("[phone-number location={$id}]"); ?>
  </p>


  <?php
endforeach;
