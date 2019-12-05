<?php
$json_string = file_get_contents(plugin_dir_path( __FILE__ ) . '../content/optio-videos.json');
$categories = json_decode($json_string);
?>

<style>
  .wp-media-buttons .mlb_add_video span.wp-media-buttons-icon:before {
    font: 400 18px/1 dashicons;
    speak: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    content: '\f235';
  }
</style>

<div id="mlb-select-video" style="display: none;">
  <div>
    <p>
      <a href="#" class="button-primary insert-all-videos" >Insert Video Library</a> or choose a single video below
    </p>
    <div id="video-tabs" class="widefat">
      <h2 class="nav-tab-wrapper">
        <?php foreach( $categories as $index => $category ) : ?>
          <a href=".optio-tab-<?php echo $index; ?>" class="nav-tab"><?php echo $category->title; ?></a>
        <?php endforeach; ?>
      </h2>

      <?php foreach( $categories as $index => $category ) : ?>
        <div style="display: none;" class="optio-tab-<?php echo $index; ?> video-tab">
          <ul>
            <?php foreach( $category->videos as $video ) : ?>
              <li class="row-title">
                <a href="#" data-optio-id="<?php echo $video->id; ?>" class="video-link"><?php echo $video->title; ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<a href="#" id="mlb-insert-video" class="button mlb_add_video"><span class="wp-media-buttons-icon"></span> Add Video</a>