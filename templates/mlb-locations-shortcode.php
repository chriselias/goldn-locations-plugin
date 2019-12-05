<?php
$business_ids = explode(',', $attributes['ids']);
foreach($business_ids as $id) :
  ?>

  <h3><span itemprop="name"><?php echo do_shortcode("[common-name location={$id}]"); ?></span></h3>

  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <?php echo do_shortcode("[address location={$id}]"); ?><br />
  <?php echo do_shortcode("[city location={$id}]"); ?>, <?php echo do_shortcode("[state location={$id}]"); ?> <?php echo do_shortcode("[zip location={$id}]"); ?><br />
     <?php echo do_shortcode("[phone-number location={$id}]"); ?>
  </div>

  <span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
    <meta itemprop="latitude" content='<?php echo do_shortcode("[lat location={$id}]"); ?>' />
    <meta itemprop="longitude" content='<?php echo do_shortcode("[lon location={$id}]"); ?>' />
</span>



  <?php
endforeach;
