<?php

class MLB_Locations_Shortcodes {
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  public function create_phone_number_shortcode( $atts) {

     $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    
  //  print_r($atts);

    $business = $this->get_business($atts['location']);
    $phone = isset($business[0]->phone) ? $business[0]->phone : '';
    $phone = '('.substr($phone,0,3).") ".substr($phone,3,3)."-".substr($phone,6);

    return $phone;
  }

  public function create_business_name_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $name = $business[0]->name;
    return $name;
  }

  public function create_common_name_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);

    if (isset($business[0]->commonName)) {
      return $business[0]->commonName;
    } else {
      return $business[0]->name;
    }
  }

  public function create_city_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $city = $business[0]->city;  

    return '<span itemprop="addressLocality">' . $city . '</span>';
  }

  public function create_state_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $state = $business[0]->state;

    return '<span itemprop="addressRegion">' . $state . '</span>';
  }

  public function create_address_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
   $business = $this->get_business($atts['location']);
    $address = $business[0]->address;

    return '<span itemprop="streetAddress">' . $address . '</span>';
  }

  public function create_zip_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
   $business = $this->get_business($atts['location']);
   $zip = $business[0]->zip;

    return '<span itemprop="postalCode">' . $zip . '</span>';
  }

  public function create_lat_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $lat = $business[0]->lat;

    return $lat; 
  }

  public function create_lon_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $lon = $business[0]->lon;

    return $lon;
  }


  public function create_industry_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business = $this->get_business($atts['location']);
    $industry = $business[0]->industry;

    return $industry;
  }

  public function create_schema_shortcode($atts, $content = null) {
    
      $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
      ), $atts );

      $business_details = $this->get_business_details($atts['location']);
      $industry = isset($business_details['industry']) ? $business_details['industry'] : $business_details[0]['industry'];

      if($industry === 'podiatrist') {
        $industry = 'Podiatric';
      }

      if($industry === 'chiropractor') {
        $industry = 'Chiropractic';
      }

      $url = '<div itemscope itemtype="http://schema.org/' . $industry . '">' . do_shortcode($content) . '</div>';

      return $url;
    
      }
      public function create_schema_industry_shortcode($atts, $content = null) {
        
          $atts = shortcode_atts(
          array(
            'location' => get_option('mlb_business_id')
          ), $atts );
    
          $business_details = $this->get_business_details($atts['location']);
          $industry = isset($business_details['industry']) ? $business_details['industry'] : $business_details[0]['industry'];
    
          if($industry === 'podiatrist') {
            $industry = 'Podiatric';
          }
    
          if($industry === 'chiropractor') {
            $industry = 'Chiropractic';
          }
          return $industry;
          } 

  public function create_facebook_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
      ), $atts );

    $business_details = $this->get_business_details($atts['location']);
    $links = isset($business_details['links']) ? $business_details['links'] : $business_details[0]['links'];

    return isset($links['facebook']) ? $links['facebook'] : null;
  }

  public function create_twitter_shortcode( $atts ) {
    $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
      ), $atts );

    $business_details = $this->get_business_details($atts['location']);
    $links = isset($business_details['links']) ? $business_details['links'] : $business_details[0]['links'];

    return isset($links['twitter']) ? $links['twitter'] : null;
  }

  public function create_page_title_shortcode() {
    global $post;

    return $post->post_title;
  }

  public function create_hours_shortcode( $atts ) {
 
     $atts = shortcode_atts(
      array(
        'location' => get_option('mlb_business_id')
     ), $atts );
    $business_details = $this->get_business($atts['location']);
    $business_details = $business_details[0]->hours;

    $arr = json_decode($business_details);

    $day_rows = function($arr) {
    $rows = '';
    foreach($arr as $day) {
      $row = '<tr>';

      if ($day->closed) {
         $row .= '<td>' . ucfirst($day->day) . '</td>';
         $row .= '<td colspan="2">Closed</td>';
      }else {
          $row .= '<td>' . ucfirst($day->day) . '</td>';
          $row .= '<td>' . date('g:i a', $day->open) . '</td>';
          $row .= '<td>' . date('g:i a', $day->close) .'</td>';
        }
       $row .= '</tr>';

       $rows .= $row;
    }
    return $rows;
  };

  $hours_table = <<<EOD
			<div class="table-responsive hours">
				<table class="table">
					{$day_rows($arr)}
				</table>
			</div>
EOD;

    return $hours_table;
}

  public function create_optio_shortcode($attributes, $content = '') {
    $attributes = shortcode_atts(array(
      'id' => ''
    ), $attributes);

    $video = '<script src="//www.optiopublishing.com/embed/"></script>';

    if ($attributes['id']) {
      $video = '<script src="//www.optiopublishing.com/embed/?control=video_player&video=' . $attributes['id'] . '"></script>';
    }

    return $video;
  }

  public function create_viewmedica_shortcode( $attributes, $content = '' ) {
    $attributes = shortcode_atts(array(
      'id' => ''
    ), $attributes);

    $viewmedica_id = $this->get_viewmedica_id();

    $video = "<div class=\"embed-responsive embed-responsive-16by9\"><div id=\"A_{$attributes['id']}\"></div></div>";
    $video .= '<script type="text/javascript" src="https://www.swarminteractive.com/js/vm.js"></script>';

    if ($attributes['id']) {
      $video .= "<script type=\"text/javascript\">client=\"{$viewmedica_id}\"; openthis=\"A_{$attributes['id']}\"; width=580; vm_open();</script>";
    } else {
      $video .= "<script type=\"text/javascript\">client=\"{$viewmedica_id}\"; width=580; vm_open();</script>";
    }

    return $video;
  }

  public function create_ohi_shortcode($attributes, $content = '') {
    $attributes = shortcode_atts(array(
      'id' => ''
    ), $attributes);

    if ($attributes['id']) {
      $video = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//content.jwplatform.com/players/' . $attributes['id'] . '-JzLCD2uq.html" width="480" height="270" frameborder="0" scrolling="auto" allowfullscreen></iframe></div>';
    }

    return $video;
  }

  public function create_social_icon_shortcode($attributes, $content = '') {

    $attributes = shortcode_atts(array(
      'url' => '',
      'icon' => 'facebook-square',
      'size' => 'lg',
      'color' => '#000',
      'right' => '5',
      'left' => '5',
      'window' => 'blank'

    ), $attributes);

    if ($attributes['url']) {
      $social_icon = '<a href="' . $attributes['url'] . '" style="color:' . $attributes['color'] . '; padding-right:'. $attributes['right'] .'px; padding-left:'. $attributes['left'] .'px;" class="mlb-social-icon mlb-'. $attributes['icon'] .'-icon" rel="noopener" target="_' . $attributes['window'] . '"> <i class="fa fa-' . $attributes['size'] . ' fa-'. $attributes['icon'] .'"></i></a>';
    }

    return $social_icon;

  }
  public function create_locations_shortcode( $attributes ) {
    $attributes = shortcode_atts(array(
      'ids' => ''
    ), $attributes);

    // check for template in active theme
    $template = locate_template(array('mlb-locations-shortcode.php'));

    // if none found use the default template
    if ( $template == '' ) $template = plugin_dir_path( __FILE__ ) . '../templates/mlb-locations-shortcode.php';

    ob_start();
    include($template);
    $output = ob_get_clean();
    return $output;
  }

  public function add_video_button() {
    include(plugin_dir_path( __FILE__ ) . '../templates/mlb-insert-video-modal.php');
  }

  public function include_video_button_js() {
    wp_enqueue_script('video-button', plugin_dir_url( __FILE__ ) . '../js/video-button.js', array('jquery', 'jquery-ui-tabs'), '1.0', true);
  }

  public function add_locations_button() {
    include(plugin_dir_path( __FILE__ ) . '../templates/mlb-insert-locations-modal.php');
  }

  public function include_locations_button_js() {
    wp_enqueue_script('locations-button', plugin_dir_url( __FILE__ ) . '../js/locations-button.js', array('jquery', 'jquery-ui-tabs'), '1.0', true);
  }

  public function get_business($locations) {
     $business_details = get_transient( 'business_details' ); 
    if ( $business_details !== false ) {
         if ( !is_array($locations) ) {
             $locations = [$locations];
         }
      // check if there is only 1 business, return if true
      if ( count($locations) === count($business_details) ) {
        return $business_details;
      }

      $filtered_business_details = [];
      foreach( $locations as $location ) {
        foreach( $business_details as $business ) {
         if ( strcasecmp( $business->id, $location ) ) {
          $filtered_business_details[] = $business;
         }
        }
      }
      return $filtered_business_details;

    }

    $apiUrl = 'https://app.mylocalbeacon.com/api/getBusinessLocation/';

    $business_ids = get_option( 'mlb_business_id' );

    $business_ids = is_array($business_ids) ? $business_ids : array($business_ids);
    $business_details = [];


    foreach($business_ids as $business_id) {
        $json = wp_remote_post($apiUrl . $business_id);
        $business = json_decode($json['body']);	
  
        $business_details[] = $business;
      }
      
    
    
    set_transient( 'business_details', $business_details, 60 );  // 1 minute
		return $business_details;

  }

  public function get_business_details($locations) {
    $business_details = get_transient( 'business_details' ); 

    if ( $business_details !== false ) {
      if ( count($locations) === count($business_details) ) {
        return $business_details;
      }

      if ( !is_array($locations) ) {
        $locations = [$locations];
      }

      $filtered_business_details = [];
      foreach( $locations as $location ) {
        foreach( $business_details as $business ) {
          if ( strcasecmp( $business['id'], $location ) ) {
            $filtered_business_details[] = $business;
          }
        }
      }

      return $filtered_business_details;
    }


    $business_ids = get_option( 'mlb_business_id' );

    $business_ids = is_array($business_ids) ? $business_ids : array($business_ids);
    $business_details = [];

    foreach ($business_ids as $business_id) {
      try {
        $conn = new PDO("dblib:host=$server;dbname=$database", $username, $password);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $statement = $conn->prepare('EXEC GetBusinessByIdAndAccountId @BusinessId = ?');
        $statement->execute(array($business_id));
        $results = $statement->fetch();
        $temp_details = json_decode($results[0], true);
        $sanitized_details = array(
          'id'              => $temp_details['id'],
          'links'           => $temp_details['links'],
          'city'            => $temp_details['city'],
          'state'           => $temp_details['state'],
          'phone'           => $temp_details['phone'],
          'industry'        => $temp_details['industry'],
          'name'            => $temp_details['name'],
          'address'         => $temp_details['address'],
          'zip'             => $temp_details['zip'],
          'hours'           => $temp_details['hours'],
          'lat'             => $temp_details['lat'],
          'lon'             => $temp_details['lon'],
          'commonName'      => $temp_details['commonName']
        );
        $business_details[] = $sanitized_details;

      } catch ( PDOException $e ) {
        $business_details[] = array(
          'links'     => '',
          'city'      => '',
          'state'     => '',
          'phone'     => '',
          'industry'  => '',
          'name'      => '',
          'address'   => '',
          'zip'       => '',
          'lat'       => ''
        );
        return $business_details;
      }
    }

    set_transient( 'business_details', $business_details, 60 );  // 1 minute

    if ( count($locations) === count($business_details) ) {
      return $business_details;
    }

    if ( !is_array($locations) ) {
      $locations = [$locations];
    }

    $filtered_business_details = [];
    foreach( $locations as $location ) {
      foreach( $business_details as $business ) {
        if ( strcasecmp( $business['id'], $location ) ) {
          $filtered_business_details[] = $business;
        }
      }
    }

    return $filtered_business_details;
  }

  public function get_viewmedica_id() {
    $viewmedica_id = get_transient( 'viewmedica_id' );

    if ( $viewmedica_id !== false ) {
      return $viewmedica_id;
    }

    $server = 'beaconserver.database.windows.net';
    $username = 'chicagoadmin';
    $password = 'abunchabitsnstuff1!';
    $database = MSSQL_DB;

    $website_id = get_current_blog_id();

    try {
      $conn = new PDO("dblib:host=$server;dbname=$database", $username, $password);
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
      die();
    }

    $statement = $conn->prepare('EXEC GetViewmedicaIdByBlogId @BlogId = ?');
    $statement->execute(array($website_id));
    $results = $statement->fetch();

    set_transient( 'viewmedica_id', $results['viewmedicaId'], 60 );  // 1 minute

    return $results['viewmedicaId'];
  }
}
