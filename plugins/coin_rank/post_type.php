<?php
/*
Plugin Name: import coins
Description: import coins to wordpress post.
Version: 1.0
Author: M.Shifan
*/

function custom_rest_api_history()
{
    register_rest_route(
        'fish_trade_api/v1',  // Your unique namespace
        '/get_post',   // The endpoint route
        array(
            'methods' => 'GET',
            'callback' => 'add_data_in_post',
        )
    );
    register_rest_route(
        'fish_trade_api/v1',  // Your unique namespace
        '/import_coins_new',   // The endpoint route
        array(
            'methods' => 'GET',
            'callback' => 'add_data_in_post_new',
        )
    );

	register_rest_route(
		'fish_trade_api/v1',  // Your unique namespace
		'/updatemeta',   // The endpoint route
		array(
			'methods' => 'GET',
			'callback' => 'updatemeta',
		)
	);

    register_rest_route(
        'fish_trade_api/v1',  // Your unique namespace
        '/images_upload',   // The endpoint route
        array(
            'methods' => 'GET',
            'callback' => 'custom_post_add_images',
        )
    );
}

add_action('rest_api_init', 'custom_rest_api_history');
function updatemeta(){

	$args = array(
		'post_type'      => 'signals',
		'post_status'    => 'publish',
		'posts_per_page' => -1, // Use -1 to get all published posts
	);

	$signals_posts = get_posts( $args );
    foreach($signals_posts as $p){
        update_post_meta($p->ID,'ticker_type','crypto');
    }

//    var_dump($signals_posts);

}
function custom_post_add_images (){

    $args = array(
        'post_type'      => 'coins_new',
        'post_status'    => 'publish',
        'posts_per_page' => -1, // Use -1 to get all published posts
    );
    $posts = get_posts( $args );
    foreach($posts as $p){
        $thumbnail =  has_post_thumbnail($p->ID);
        $symbol = get_post_meta($p->ID,'coin_symbol',true);
        var_dump($symbol,$p->ID,$thumbnail);exit;
    }
}
function custom_post_type_plugin_register_post_type()
{
    $labels = array(
        'name' => 'Coins',
        'singular_name' => 'Coin',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Coin',
        'edit_item' => 'Edit Coin',
        'new_item' => 'New Coin',
        'view_item' => 'View Coin',
        'search_items' => 'Search Coins',
        'not_found' => 'No coins found',
        'not_found_in_trash' => 'No coins found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Coins',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'coins'),
    );

    register_post_type('coins','');
    add_action('add_meta_boxes', 'add_coin_meta_box');
}

add_action('init', 'custom_post_type_plugin_register_post_type');

function add_coin_meta_box()
{
    add_meta_box(
        'coin_meta_box',
        'Coin Information',
        'render_coin_meta_box',
        'coins',
        'normal',
        'high'
    );
}

function render_coin_meta_box($post)
{
    // Retrieve existing value from the database
//    $selected_value = get_post_meta($post->ID, '_coin_status', true);
    $coin_type = get_post_meta($post->ID, '_coin_type', true);
    $post_id = $post->ID;

// Retrieve the value of the '_coin_status' meta field
    $symbol_set = get_post_meta($post_id, '_coin_symbol', true);


    ?>
    <div class="coin_type_div" style="display: flex;flex-direction: column;">
        <label for="coin_type" ">Coin Type:</label>
        <select name="coin_type" class="coin_type">
            <option value="0">Select Type</option>
            <option value="crypto" <?php echo $coin_type != '' && $coin_type == 'crypto' ? 'selected' : ''; ?>>
                Crypto
            </option>
            <option value="stocks" <?php echo $coin_type != '' && $coin_type == 'stocks' ? 'selected' : ''; ?>>
                Stocks
            </option>
            <option value="commodities" <?php echo $coin_type != '' && $coin_type == 'commodities' ? 'selected' : ''; ?>>
                Commodities
            </option>
            <option value="fx" <?php echo $coin_type != '' && $coin_type == 'fx' ? 'selected' : ''; ?>>FX</option>
            <option value="indices"<?php echo $coin_type != '' && $coin_type == 'indices' ? 'selected' : ''; ?>>
                Indices
            </option>
        </select>
    </div>
    <?php


//    // Define options for the select drop-down
//    $options = array(
//        'Cryptocurrency' => 'Cryptocurrency',
//        'index' => 'index',
//        'commodity_backed' => 'commodity backed',
//        'Crypto' => 'Crypto',
//        'stablecoin' => 'stablecoin',
//    );
//
//    // Output the select drop-down field
//    echo '<br>' . '<label for="coin_status">Coin Status</label>';
//    echo '<br>' . '<select id="coin_status" name="coin_status">';
//    echo '<option value="0">Select Option </option>';
//
//    foreach ($options as $value => $label) {
//        echo '<option value="' . esc_attr($value) . '" ' . selected($selected_value, $value, false) . '>' . esc_html($label) . '</option>';
//    }
//
//    echo '</select>';

    // Output the symbol input field
    echo '<br> <br>' . '<label for="coin_symbol">Coin Symbol</label>';
    echo '<br>' . '<input type="text" id="coin_symbol" name="coin_symbol" value="' . esc_attr($symbol_set) . '" />';

}

// Save the selected value when the post is saved
add_action('save_post', 'save_coin_status_meta_box');

function coin_symbol_save($post)
{

}

add_action('save_post', 'save_coin_status_meta_box');
function save_coin_status_meta_box($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['coin_type'])) {
        update_post_meta($post_id, '_coin_type', sanitize_text_field($_POST['coin_type']));
    }
    if (isset($_POST['coin_symbol'])) {
        update_post_meta($post_id, '_coin_symbol', sanitize_text_field($_POST['coin_symbol']));
    }
}

//function fetch_and_save_coin_data_from_api($last_offset)
//{
//
//    $perPage = 20;
//    $page = $last_offset ? intval($last_offset) : 1;
//    $offset = ($page - 1) * $perPage;
//    $url = 'https://api.coinranking.com/v2/coins?offset=' . $offset . '&limit=' . $perPage;
//
//    $curl = curl_init($url);
//    $headers = [
//        'Content-Type: application/json',
//        'x-access-token: coinrankinge91c55d01c9c393570b5b68db94cead72482163729556f7a',
//    ];
//    // Set cURL options
//    curl_setopt_array($curl, array(
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'GET',
//        CURLOPT_HTTPHEADER => $headers
//    ));
//
//    // Execute cURL and check for errors
//    $response = curl_exec($curl);
//    if ($response === false) {
//        echo 'cURL error: ' . curl_error($curl);
//        exit;
//    }
//
//    // Close cURL
//    curl_close($curl);
//
//    // Decode JSON response
//    $data = json_decode($response, true);
//    // Check if decoding was successful
//    if ($data === null) {
//        echo 'Error decoding JSON';
//        exit;
//    }
//
//    $coin_data = array();
//    if (isset($data['status']) && $data['status'] == 'success') {
//        foreach ($data['data']['coins'] as $coin) {
//            $media_id = save_coin_data($coin['name'], $coin['iconUrl']);
//
//            $coin_data[] = array(
//                'name' => $coin['name'],
//                'symbol' => $coin['symbol'],
//                'icon_url' => $coin['iconUrl'],
//                'media_id' => $media_id,
//            );
////            var_dump($coin_data);exit;
//        }
//    }
//
//    return $coin_data;
//}

function fetch_and_save_coin_data_from_api($last_offset)
{
    $perPage = 20;
    $page = $last_offset ? intval($last_offset) : 1;
    $offset = ($page - 1) * $perPage;
    $offset = $offset == 0 ? 1 : $offset;

//    var_dump($offset);
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/map?limit='.$perPage.'&start=' . $offset;
    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 162f038a-6b01-4be5-8028-b122015604c1'
    ];
//$qs = http_build_query($parameters); // query string encode the parameters
    $request = "{$url}"; // create the request URL

    $curl = curl_init(); // Get cURL resource
// Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));

    $response = curl_exec($curl); // Send the request, save the response
    $response = json_decode($response); // print json decoded response
//var_dump($response->data);exit;
    $coin_data = array();
    foreach ($response->data as $coin) {

        $get_coin_url = get_icon_url_api($coin->id, $coin->slug);
//        var_dump($get_coin_url);
//              var_dump($get_coin_url);exit();
        if($get_coin_url == ''){
            $media_id = save_coin_data($coin->name,$get_coin_url);
        }else{
            $media_id = '';
        }

        $coin_data[] = array(
            'name' => $coin->name,
            'symbol' => $coin->symbol,
            'icon_url' => $get_coin_url,
            'media_id' => $media_id,
        );
//        var_dump($coin_data);exit;
    }

    return $coin_data;
    curl_close($curl); // Close request


}


function save_coin_data($coinName, $iconUrl)
{
    // Check if post type already exists
    $existing_post = get_page_by_title($coinName, OBJECT, 'your_post_type');

    if ($existing_post) {
        // Post with the same title already exists, return without adding media
        return $existing_post->ID;
    }

    // Continue with media upload
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $file_extension = pathinfo($iconUrl, PATHINFO_EXTENSION);

    $filename = sanitize_title($coinName) . '.' . $file_extension;

    $file_array = array(
        'name' => $filename,
        'tmp_name' => download_url($iconUrl),
    );

    if (strtolower($file_extension) === 'svg') {
        $file_array['type'] = 'image/svg+xml';
    }

    $media_id = media_handle_sideload($file_array, 0);

    if (!is_wp_error($media_id)) {
        update_post_meta($media_id, '_coin_name', $coinName);
        update_post_meta($media_id, '_coin_icon_url', $iconUrl);
    }

    return $media_id;
}

// add_action('init', 'add_data_in_post');

function add_data_in_post()
{
    $last_offset = get_option('coins_last_offset');
    $coin_data = fetch_and_save_coin_data_from_api($last_offset);
//    var_dump($coin_data);exit;
    $api_exec = true;
    if (!empty($coin_data)) {
        foreach ($coin_data as $value) {

            $existing_post = get_page_by_title($value['name'], OBJECT, 'coins');
//            var_dump($existing_post->ID);die();
            if (!$existing_post) {

                $post_data = array(
                    'post_title' => $value['name'],
                    'post_type' => 'coins',
                    'post_status' => 'publish',
                );

                $post_id = wp_insert_post($post_data);

                if ($post_id) {
                    $image_url = $value['icon_url'];
                    $image_id = upload_and_set_featured_image($image_url, $post_id);
                    update_post_meta($post_id, '_coin_symbol', $value['symbol']);

                    if ($image_id) {
//                        update_post_meta($post_id, '_coin_symbol', $value['symbol']);
                        echo "Post created successfully with ID: $post_id, symbol: {$value['symbol']}, and image attached with ID: $image_id";
//                        echo "Post created successfully with ID: $post_id and image attached with ID: $image_id";
                    } else {
                        echo "Error attaching image to post";
                    }
                } else {
                    echo "Error creating post";
                }
            } else {
                $symbol = get_post_meta($existing_post->ID, '_coin_symbol', true);
                if ($symbol == '' && !empty($symbol)) {
                    update_post_meta($existing_post->ID, '_coin_symbol', $value['symbol']);
                }
                echo "Post with title '{$value['name']}' already exists. Skipping insertion.";
            }


        }
        update_option('coins_last_offset', $last_offset == 0 ? 2 : intval($last_offset) + 1);
    }

}


function allow_svg_upload($existing_mimes)
{
    $existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
}

add_filter('upload_mimes', 'allow_svg_upload');


function upload_and_set_featured_image($image_url, $post_id)
{
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $file_array = array(
        'name' => basename($image_url),
        'tmp_name' => download_url($image_url),
    );

    $image_id = media_handle_sideload($file_array, $post_id, 'post_title');

    if (!is_wp_error($image_id)) {
        set_post_thumbnail($post_id, $image_id);
    }

    return $image_id;
}


// Hook into that action that'll fire every 2 minutes
add_action('coin_post_import', 'add_data_in_post_new');


// Schedule the event on plugin activation
register_activation_hook(__FILE__, 'coin_cron_scheduler');

function coin_cron_scheduler()
{
    if (!wp_next_scheduled('coin_post_import')) {
        wp_schedule_event(time(), 'every_two_minutes', 'coin_post_import');
    }
}


// Schedule interval for every 2 minutes
function my_custom_cron_intervals($schedules)
{
    $schedules['every_two_minutes'] = array(
        'interval' => 120, // 2 minutes in seconds
        'display' => __('Every 2 Minutes'),
    );
    return $schedules;
}

add_filter('cron_schedules', 'my_custom_cron_intervals');


//new_work----->>>>>>>>>>>>>>>


function custom_post_type_plugin_register_post_type_new()
{
    $labels = array(
        'name' => 'Coins',
        'singular_name' => 'Coin',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Coin',
        'edit_item' => 'Edit Coin',
        'new_item' => 'New Coin',
        'view_item' => 'View Coin',
        'search_items' => 'Search Coins',
        'not_found' => 'No coins found',
        'not_found_in_trash' => 'No coins found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Coins',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'coins'),
    );

    register_post_type('coins_new', $args);
    add_action('add_meta_boxes', 'add_coin_meta_box');
}

add_action('init', 'custom_post_type_plugin_register_post_type_new');


function add_data_in_post_new()
{
    $last_offset = get_option('new_coins_last_offset');

    if($last_offset >= 25){
        $last_offset = 0;
    }

//    var_dump($last_offset);exit;
    $coin_data = fetch_and_save_coin_data_from_api($last_offset);
//    var_dump($coin_data);exit;
    $api_exec = true;
    if (!empty($coin_data)) {
        foreach ($coin_data as $value) {

            $existing_post = get_page_by_title($value['name'], OBJECT, 'coins_new');
//            var_dump($existing_post->ID);die();
            if (!$existing_post) {

                $post_data = array(
                    'post_title' => $value['name'],
                    'post_type' => 'coins_new',
                    'post_status' => 'publish',
                );

                $post_id = wp_insert_post($post_data);


                if ($post_id) {
                    $image_url = $value['icon_url'];
                    $image_id = upload_and_set_featured_image($image_url, $post_id);
                    update_post_meta($post_id, '_coin_symbol', $value['symbol']);
                    update_post_meta($post_id, '_coin_type','crypto');

                    if ($image_id) {
//                        update_post_meta($post_id, '_coin_symbol', $value['symbol']);
                        echo "Post created successfully with ID: $post_id, symbol: {$value['symbol']}, and image attached with ID: $image_id";
//                        echo "Post created successfully with ID: $post_id and image attached with ID: $image_id";
                    } else {
                        echo "Error attaching image to post";
                    }
                } else {
                    echo "Error creating post";
                }
            } else {
                $symbol = get_post_meta($existing_post->ID, '_coin_symbol', true);
                if ($symbol == '' && !empty($symbol)) {
                    update_post_meta($existing_post->ID, '_coin_symbol', $value['symbol']);
                }
                echo "Post with title '{$value['name']}' already exists. Skipping insertion.";
            }


        }
        update_option('new_coins_last_offset', $last_offset == 0 ? 2 : intval($last_offset) + 1);
    }

}

function get_icon_url_api($id,$slug){


    $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/info?slug='.$slug;
    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 162f038a-6b01-4be5-8028-b122015604c1'
    ];
//$qs = http_build_query($parameters); // query string encode the parameters
    $request = "{$url}"; // create the request URL

    $curl = curl_init(); // Get cURL resource
// Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));
    $response = curl_exec($curl); // Send the request, save the response
    $response = json_decode($response);
//    var_dump($response,$id,$slug);
    $logo_url = ($response !== null) ? $response->data->$id->logo : '';
    curl_close($curl); // Close request
    return $logo_url;

}



// Add meta box to custom post type
function custom_post_type_meta_box() {
    add_meta_box(
        'coin_meta_box', // Unique ID
        'Coin Meta Box', // Box title
        'coin_meta_box_callback', // Content callback function
        'coins_new', // Post type
        'normal', // Context
        'high' // Priority
    );
    add_meta_box(
        'api_data_meta_box', // Unique ID
        'Detail Meta Box', // Box title
        'asset_meta_box_callback', // Content callback function
        'coins_new', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_post_type_meta_box');

// Meta box content callback function
function coin_meta_box_callback($post) {
    $symbol_set = get_post_meta($post->ID, '_coin_symbol', true);
    echo '<label for="coin_symbol">Ticker</label>';
    echo '<br>' . '<input type="text" id="coin_symbol" name="coin_symbol" value="' . esc_attr($symbol_set) . '" />';
}

// Save meta box data
function save_custom_meta_box_data($post_id) {
    // If this is an autosave, our form has not been submitted, so don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['coin_symbol'])) {
        update_post_meta($post_id, '_coin_symbol', sanitize_text_field($_POST['coin_symbol']));
        modula_api($post_id,$_POST['coin_symbol']);
    }
}
add_action('save_post', 'save_custom_meta_box_data');

function modula_api($post_id, $name) {
    $name = str_replace(' ', '%20', $name);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mobula.io/api/1/market/data?asset=' . $name,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'apikey: d3cd6751-cd35-437a-bb02-6fe3cabf775f',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
//    var_dump($response);
//    exit();

    curl_close($curl);
    add_signal_supabase($response);

    update_post_meta($post_id, 'asset_data', $response);
}
//DFGHJK
 function add_signal_supabase($response)
{

//    // Access the id from the decoded object
     $object = json_decode($response, true);
     $data = $object['data'];
     // Specify the fields you want to display
     $fields_to_display = [
         'price',
         'price_change_24h',
         'price_change_1h',
         'price_change_7d',
         'price_change_1m',
         'price_change_1y'
     ];


// Create a new array from the existing data
     $newData = array();
     foreach ($data as $key => $value) {
         if (in_array($key, $fields_to_display)) {

             $newData[$key] = $value;
         }
     }

     $id = $data['data']['id'];
     $market_cap =

// Output the id to verify
//     var_dump($id);
//     exit();

    $url = 'https://fztbojbqsietuamhlfqk.supabase.co/rest/v1/asset';
    $data = $newData;
    $payload = json_encode($data);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
        'Content-Type: application/json',
        'Prefer: return=minimal'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        die('Curl error: ' . $error);
    }

    curl_close($ch);
//    echo $response;
}
//DFGHJKL


function asset_meta_box_callback($post){
    $custom_field_value = get_post_meta($post->ID, 'asset_data', true);
    $custom_field_value = json_encode($custom_field_value);
    $custom_field_value = json_decode($custom_field_value);
    $object = json_decode($custom_field_value);
    $data = $object->data;

    // Specify the fields you want to display
    $fields_to_display = [
        'price',
        'price_change_24h',
        'price_change_1h',
        'price_change_7d',
        'price_change_1m',
        'price_change_1y'
    ];

    ?>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            <?php
//            echo '<pre>';
//            var_dump($data);
//            exit;

            foreach ($data as $key => $value) {
                if (in_array($key, $fields_to_display)) {
                $title = str_replace("_"," ",$key);
                echo '<tr>';
                echo '<td style="font-weight: bold;text-transform: capitalize">' . htmlspecialchars($title) . '</td>';


                if($key == "contracts"){
                    if (isset($data->contracts) && is_array($data->contracts)) {
                        echo '<td><ul>';
                        foreach ($data->contracts as $contract) {
                            if (is_object($contract)) {
                                foreach ($contract as $key => $value) {
                                    echo '<li><b>' . htmlspecialchars($key) . '</b>: ' . htmlspecialchars($value) . '</li>';
                                }
                            }
                        }
                        echo '</ul>';
                    } else {
                        echo 'Contracts data is not available or not an array.';
                    }
                    echo '</td>';
                }
                else{
                    echo '<td><input type="text" id="' . htmlspecialchars($key) . '" name="custom_field" class="form-control" value="' . htmlspecialchars($value) . '">';
                }
                if($key == "logo"){
                    echo '<img src="'.htmlspecialchars($value) .'" class="img-fluid mt-2" style="width: 150px;">';
                }
                echo '</td>';
                echo '</tr>';
            }
                }
            ?>

            </tbody>
        </table>
    </div>
    <?php
}
