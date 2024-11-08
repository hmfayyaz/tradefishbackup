<?php
/*
 * Plugin Name: Google Sheet Data
 * Author: author1234
 * Description: Google Sheet Data
 * Version: 1.0.0
 */

function custom_rest_api_history2()
{
    register_rest_route(
        'fish_trade_api/v1',  // Your unique namespace
        '/import_google_sheet',   // The endpoint route
        array(
            'methods' => 'GET',
            'callback' => 'display_google_sheet_Data',
        )
    );
}
add_action('rest_api_init', 'custom_rest_api_history2');
function removeEmptyArrays($array) {
    return array_filter($array, function($value) {
        // If $value is an array, recursively remove empty arrays
        if (is_array($value)) {
            $value = removeEmptyArrays($value);
        }

        // Keep elements that are not empty arrays
        return !empty($value) || is_numeric($value);
    });
}
function isEven($number) {
    return $number % 2 == 0;
}

function display_google_sheet_Data()
{

    $args = array(
        'author'        =>  1,
        'post_type'       =>  'signals',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_signal_result',
                'compare' => 'IN',
                'value' => ['correct','incorrect']
            ),
        ),
    );
    $post =get_posts($args);
//    var_dump($post);exit();
    try {
        require 'vendor/autoload.php';

        $client = new \Google_Client();

        $client->setApplicationName('Google Sheets and PHP');

        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        $client->setAccessType('offline');

        $client->setAuthConfig(__DIR__ . '/credentials.json');

        $service = new Google_Service_Sheets($client);

        $spreadsheetId = "1WKhBsbo3btzIaNjsUMUuINFZ--sktGcLg96N79Nes-w";
        $get_range = "Sheet1";

        $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
        $data = array();
        $final_value = array();
        $values = $response->getValues();

        unset($values[0]);
        foreach ($values as $value){
            $exist_post = get_page_by_title($value[2], OBJECT, 'signals');
            $exist_post_id = !is_null($exist_post)  ? $exist_post->ID : '';
            $date= date('Y-m-d',strtotime(str_replace('/','-',$value[0])));
            $start_date = $date;
            $end_date = $date;
            $post_id = wp_insert_post(array(
                'post_type' => 'signals',
                'post_title' => $value[2],
                'post_date' => $start_date,
            ));

            update_post_meta($post_id, 'opening_price', $value[4]);
            update_post_meta($post_id, 'closing_date', $end_date);
            update_post_meta($post_id, 'closing_price', $value[5]);
            update_post_meta($post_id, 'signal_value', strtolower($value[3]));
            update_post_meta($post_id, '_signal_result', strtolower($value[6]));
            update_post_meta($post_id,'realized_profit_or_loss',$value[7]);
            update_post_meta($post_id,'_post_title',$exist_post_id);
//            exit();

        }
        exit();
        $resultArray = removeEmptyArrays($values);
        unset($resultArray[0]);
        // If you want to reindex the array
        $resultArray = array_values($resultArray);
        $arr_1 = [];
        $arr_2 = [];
        if (!empty($resultArray)) {
                foreach($resultArray as $key => $row){
                    $rl_co = explode(' ',$row[5]);

                    if(isEven($key)) {
                        $arr_1[$key] = [
                            'asset' => $row[0],
                            'start_price' => $row[1],
                            'start_date' => $row[2],
                            'signal_type' => $row[3],
                            'confidence' => $row[4],
                            'status' => $rl_co[0],
                            'realized' => $rl_co[1],
//                            'status' => $rl_co[1],
                        ];
                    }else{
                        $arr_2[$key] = [
                            'close_price' => $row[1],
                            'close_date' => $row[2],
                        ];
                    }
                }
            $arr_1 = array_values($arr_1);
            $arr_2 = array_values($arr_2);

            $mergedArray = [];


            foreach ($arr_1 as $key => $value) {
                if (isset($arr_2[$key])) {
                    $value['asset'] = preg_replace('/\([^)]+\)/', '', $value['asset']);
                    $value['asset'] = trim($value['asset']);
                    $mergedArray[] = array_merge($value, $arr_2[$key]);
                }
            }
//            $aray = [];
            foreach ($mergedArray as $data) {
//                var_dump($data);exit();


                $exist_post = get_page_by_title($data["asset"], OBJECT, 'signals');
//                $aray[] = $exist_post;
//                var_dump($aray);exit();
                $exist_post_id = !is_null($exist_post)  ? $exist_post->ID : '';
                $start_date = date('Y-m-d H:i:s', strtotime($data['start_date']));
                $end_date = date('Y-m-d H:i:s', strtotime($data['close_date']));
                exit();
                $post_id = wp_insert_post(array(
                    'post_type' => 'signals',
                    'post_title' => $data["asset"],
                    'post_date' => $start_date,
                    'post_status'     => 'publish',
                ));

                update_post_meta($post_id, 'opening_price', str_replace('$','',$data['start_price']));
                update_post_meta($post_id, 'closing_date', $end_date);
                update_post_meta($post_id, 'closing_price', str_replace('$','',$data['close_price']));
                update_post_meta($post_id, 'signal_value', strtolower($data['signal_type']));
                update_post_meta($post_id, '_signal_result', strtolower($data['status']));
                update_post_meta($post_id,'realized_profit_or_loss',$data['realized']);
                update_post_meta($post_id,'_post_title',$exist_post_id);
                update_post_meta($post_id,'confidence',$data['confidence']);


            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
?>
