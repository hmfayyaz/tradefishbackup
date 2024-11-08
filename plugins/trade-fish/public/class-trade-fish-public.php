<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/public
 * @author     Hztech <obaidullah@hztech.biz>
 */
class Trade_Fish_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_shortcode('latest_signals', array($this, 'latest_signals_shortcode'));
        add_shortcode('signals_post_count', array($this, 'signals_post_count_shortcode'));
        add_shortcode('signal_result_count', array($this, 'signal_result_count_shortcode'));
        add_shortcode('display_data', array($this, 'display_latest_coins_shortcode'));
        add_shortcode('correct_signals', array($this, 'shortcode_count_correct_signals'));
        add_shortcode('overall_performance', array($this, 'overallPerformance_shortcode'));
        add_shortcode('history_data', array($this, 'history_data_shortcode'));
        add_shortcode('bar_chart', array($this, 'bar_chart'));
        add_shortcode('line_chart', array($this, 'line_chart'));
        add_shortcode('count_correct_signals_circular', array($this, 'count_correct_signals_circular'));
        add_action('wp_ajax_load_more_history_data', array($this, 'load_more_history_data'));
        add_shortcode('count_correct_signals', array($this, 'count_correct_signals'));
        add_action('wp_ajax_nopriv_load_more_history_data', array($this, 'load_more_history_data'));
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Trade_Fish_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Trade_Fish_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/trade-fish-public.css', array(), $this->version, 'all');
//        wp_enqueue_style($this->plugin_name, 'https://tradefish.app/wp-content/uploads/elementor/css/custom-pro-frontend-lite.min.css?ver=1705326860', array(), rand(), 'all');
//        wp_enqueue_style($this->plugin_name, 'https://wordpress-653970-4161790.cloudwaysapps.com/wp-content/uploads/elementor/css/custom-pro-frontend-lite.min.css?ver=1705574540', array(), rand(), 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Trade_Fish_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Trade_Fish_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
//        wp_enqueue_script('trade-fish-ajax', plugin_dir_url(__FILE__) . 'js/trade-fish-ajax.js', array('jquery'), $this->version, true);
//        wp_localize_script('trade-fish-ajax', 'trade_fish_ajax', array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('your_nonce_action')));
        global $wpdb;
        $args = array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'incorrect'
                ),

            ),
//            'date_query'     => array(
//                array(
//                    'after'  => date('Y-m-d', strtotime('-1 year')), // Set the start date as one year ago
//                    'before' => date('Y-m-d'), // Set the end date as today
//                    'inclusive' => true, // Include posts from the end date
//                ),
//            ),
        );

        $posts = get_posts($args);
        $count_posts = count($posts);
        $title_counts = array();

        foreach ($posts as $post) {
            $title = $post->post_title;
            $title_counts[$title] = isset($title_counts[$title]) ? $title_counts[$title] + 1 : 1;
        }
        arsort($title_counts);

        $top_six_titles = array_slice($title_counts, 0, 6, true);
        $result = [];
        foreach ($top_six_titles as $title => $count) {
            $result[] = array(
                'title' => $title,
                'count' => $count,
            );
        }

        $url = home_url('trading-signals');
        $result[] = $count_posts;
        $result[] = $url;
        $graph2 = [];
        $current_year = date('Y') - 1;
        foreach ($this->get_last_six_month_year() as $monthData) {
            $current_month = $monthData['month'];
            $current_year = $monthData['year'];
            // SQL query
            $query = $wpdb->prepare("
    SELECT MONTH(pm.meta_value) AS month,
           YEAR(pm.meta_value) AS year,
           COUNT(*) AS count
    FROM $wpdb->posts p
    INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id
    WHERE p.post_type = 'signals'
      AND p.post_status = 'publish'
      AND pm.meta_key = 'closing_date'
      AND MONTH(pm.meta_value) = %d
      AND YEAR(pm.meta_value) = %d
    GROUP BY YEAR(pm.meta_value), MONTH(pm.meta_value)
", $current_month, $current_year);

// Execute the query
            $results = $wpdb->get_results($query);

            $value = isset($results[0]) ? $results[0]->count : 0;
            array_push($graph2,$value);
        }

        // radial_graph

        $ticker_types = array("crypto", "stocks", "commodities", "fx", "indices");

        $start_of_last_year = date('Y-m-d', strtotime('-1 year'));

        $query = $wpdb->prepare("
    SELECT
           pm.meta_value AS title,
        COUNT(*) AS count
    FROM $wpdb->posts p
    INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id
    WHERE p.post_type = 'signals'
      AND p.post_status = 'publish'
      AND pm.meta_key = 'ticker_type'
      AND p.post_date >= %s  -- Filter posts from the start of the last 6 months
    GROUP BY pm.meta_value
", $start_of_last_year);

        $results2 = $wpdb->get_results($query, ARRAY_A);

        // Check and add missing ticker type
        $existing_titles = array();

        foreach ($results2 as $result2) {

            $existing_titles[] = $result2['title'];
        }

        foreach ($ticker_types as $ticker_type) {
            if (!in_array($ticker_type, $existing_titles)) {
                $results2[] = array(
                    'title' => $ticker_type,
                    'count' => '0'
                );
            }
        }
        $results2[] = array(
            'title' => "Total",
            'count' =>   $count_posts
        );

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/trade-fish-public.js', array('jquery'), rand(), true);
        wp_enqueue_script($this->plugin_name, 'https://cdn.jsdelivr.net/npm/apexcharts', '', $this->version, false);
        wp_localize_script($this->plugin_name, 'custom_admin_vars', array(
            'custom_nonce' => wp_create_nonce('custom_nonce'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'line_graph_data' => $result,
            'graph2' => $graph2,
            'graph_months' => $this->get_last_six_month(),
            'radial_graph' => $results2,
        ));

    }

    function getTimeAgo($datetime) {
        // Current datetime (in UTC)
        $currentDateTime = new DateTime();

        // Calculate the difference
        $difference = $currentDateTime->diff($datetime);

        // Convert the difference to seconds, minutes, and hours
        $secondsAgo = $difference->s + ($difference->i * 60) + ($difference->h * 3600) + ($difference->days * 24 * 3600);
        $minutesAgo = floor($secondsAgo / 60);
        $hoursAgo = floor($minutesAgo / 60);
        $daysAgo = floor($hoursAgo / 24);
        // Check if the difference is greater than one day
        // Output the result in hours ago format
        if ($hoursAgo > 0) {
            if ($hoursAgo < 24) {
                return $hoursAgo . " hour" . ($hoursAgo > 1 ? "s" : "") . " ago";
            } else {
                return $daysAgo . " day" . ($daysAgo > 1 ? "s" : "") . " ago";
            }
        } elseif ($minutesAgo > 0) {
            return $minutesAgo . " minute" . ($minutesAgo > 1 ? "s" : "") . " ago";
        } else {
            return $secondsAgo . " second" . ($secondsAgo > 1 ? "s" : "") . " ago";
        }

    }

    function get_last_six_month_year(){

        $currentDate = new DateTime(); // Current date
        $lastSixMonths = array();

// Loop to get the last 6 months
        for ($i = 1; $i <= 6; $i++) {
            $lastSixMonths[] = array(
                'year' => $currentDate->format('Y'), // Year
                'month' => $currentDate->format('m') // Month
            );
            $currentDate->sub(new DateInterval('P1M')); // Subtract 1 month
        }

// Reverse the array to have the months in descending order
        $lastSixMonths = array_reverse($lastSixMonths);

// Output the result
        return $lastSixMonths;
    }

    function get_last_six_month(){

        $currentDate = new DateTime(); // Current date
        $lastSixMonths = array();

// Loop to get the last 6 months
        for ($i = 1; $i <= 6; $i++) {
            $lastSixMonths[] = $currentDate->format('M');
            $currentDate->sub(new DateInterval('P1M')); // Subtract 1 month
        }

// Reverse the array to have the months in descending order
        $lastSixMonths = array_reverse($lastSixMonths);

// Output the result
        return $lastSixMonths;
    }

    function custom_rest_api_history()
    {
        register_rest_route(
            'fish_trade_api/v1',  // Your unique namespace
            '/get_post-history',   // The endpoint route
            array(
                'methods' => 'GET',
                'callback' => array($this, 'history_data_shortcode'),
            )
        );

    }
    public function display_latest_coins_shortcode($atts)
    {
        // Extract shortcode attributes
        $atts = shortcode_atts(
            array(
                'type' => 'all',  // Default value if not provided
            ),
            $atts,
            'custom_shortcode'
        );
        // Access the 'type' attribute
        $type = $atts['type'];
        ob_start(); // Start output buffering
        if($type == 'all'){
            $args = array(
                'post_type' => 'signals',
                'posts_per_page' => 10,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => '_signal_result',
                        'compare' => 'IN',
                        'value' => ['unset','hidden']
                    ),
                ),
            );

        }else{
            $args = array(
                'post_type' => 'signals',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_signal_result',
                        'compare' => 'IN',
                        'value' => ['unset','hidden']
                    ),
                    array(
                        'key' => 'ticker_type',
                        'compare' => '=',
                        'value' => $type
                    ),
                ),
            );
        }

        $custom_query = new WP_Query($args);

        if(!$custom_query->have_posts()){
            $args = array(
                'post_type' => 'signals',
                'posts_per_page' => 10,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => '_signal_result',
                        'compare' => 'IN',
                        'value' => ['unset','hidden']
                    ),
                ),
            );

            $posts = new WP_Query($args);
        }
        else{
            $posts = $custom_query;
        }

        $get_currencies = $this->get_currencies();

        include dirname(__FILE__) . '/partials/displayData.php';


        return ob_get_clean(); // Return the buffered output
    }


    public function signals_post_count_shortcode()
    {
        ob_start(); // Start output buffering
        $posts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'incorrect'
                ),

            ),
        ));

//        $posts = get_posts('post_type=signals&suppress_filters=0&posts_per_page=-1');
        $count = count($posts);
        if ($count > 0) {
            include dirname(__FILE__) . '/partials/trade-fish-display-total-coins.php';
        } else {
            return "no signals posts found";
        }
        return ob_get_clean(); // Return the buffered output
    }

    public function shortcode_count_correct_signals()
    {
        ob_start();
        $theposts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
            ),
        ));

        $correct_signals = count($theposts);

        include dirname(__FILE__) . '/partials/trade-fish-display-correct-signals.php';

        return ob_get_clean();

    }

    public function overallPerformance_shortcode()
    {
        ob_start();
        $theposts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
            ),
        ));
        $posts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'incorrect'
                ),

            ),
        ));
//        $posts = get_posts('post_type=signals&suppress_filters=0&posts_per_page=-1');
        $totalPostcount = count($posts);

        $correct_signals = count($theposts);
        $percentage = ($correct_signals / $totalPostcount) * 100;
        $percentage = round($percentage, 2);

        include dirname(__FILE__) . '/partials/trade-fish-display-overall-performance.php';

        return ob_get_clean();
    }

    public function history_data_shortcode($atts)
    {

        // Extract shortcode attributes
        $atts = shortcode_atts(
            array(
                'type' => 'all',  // Default value if not provided
            ),
            $atts,
            'history_data'
        );

        // Access the 'type' attribute
        $type = $atts['type'];

        ob_start();

        $post_per_page = 20;
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;

        if($type == 'all'){
            $args = array(
                'post_type' => 'signals',
                'posts_per_page' => $post_per_page,
                'meta_key'       => 'closing_date',
                'orderby'        => 'meta_value',
                'order'          => 'DESC',
                'paged' => $current_page,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => '_signal_result',
                        'compare' => '=',
                        'value' => 'correct'
                    ),
                    array(
                        'key' => '_signal_result',
                        'compare' => '=',
                        'value' => 'incorrect'
                    ),

                ),
            );
        }
		else{
            $args = array(
                'post_type' => 'signals',
                'posts_per_page' => $post_per_page,
                'meta_key'       => 'closing_date',
                'orderby'        => 'meta_value',
                'order'          => 'DESC',
                'paged' => $current_page,
                'meta_query'     => array(
                    'relation' => 'AND', // Change to 'AND' to include the new meta query condition
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => '_signal_result',
                            'compare' => '=',
                            'value'   => 'correct',
                        ),
                        array(
                            'key'     => '_signal_result',
                            'compare' => '=',
                            'value'   => 'incorrect',
                        ),
                    ),
                    array(
                        'key'     => 'ticker_type',
                        'compare' => '=',
                        'value'   => $type,
                    ),
                ),
            );
        }



        $custom_query = new WP_Query($args);

//        if(!$custom_query->have_posts()){
//            $args = array(
//                'post_type' => 'signals',
//                'posts_per_page' => $post_per_page,
//                'orderby' => 'date',
//                'order' => 'DESC',
//                'paged' => $current_page,
//                'meta_query' => array(
//                    'relation' => 'OR',
//                    array(
//                        'key' => '_signal_result',
//                        'compare' => '=',
//                        'value' => 'correct'
//                    ),
//                    array(
//                        'key' => '_signal_result',
//                        'compare' => '=',
//                        'value' => 'incorrect'
//                    ),
//
//                ),
//            );
//            $posts = new WP_Query($args);
//
//        }
//		else{
//            $posts = $custom_query;
//        }
	    $posts = new WP_Query($args);
        $get_currencies = $this->get_currencies();
        include dirname(__FILE__) . '/partials/trade-fish-history-data.php';
        // Output pagination links
        $total_pages = $custom_query->max_num_pages;
        if ($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
            $pagination_links = paginate_links(array(
                'base' => str_replace( 999999999, '%#%', get_pagenum_link(999999999)),
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text' => __('<i class="fa fa-chevron-left" aria-hidden="true"></i>'),
                'next_text' => __('<i class="fa fa-chevron-right" aria-hidden="true"></i>'),
                'mid_size' => 4,
                'end_size' => 1,
                'type' => 'array',
            ));

            // Add first page link
            $first_page_link = '<a class="first-pge" href="' . esc_url(get_pagenum_link(1)) . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
            array_unshift($pagination_links, $first_page_link);

            // Add custom link after the first page link if the current page is 1
            if ($current_page == 1) {
                $custom_link_after_first = '<span class="prev page-numbers dsbl_link"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>';
                array_splice($pagination_links, 1, 0, $custom_link_after_first);
            }

// Add last page link
            $last_page_link = '<a class="last-pge" href="' . esc_url(get_pagenum_link($total_pages)) . '"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
            if ($current_page == $total_pages) {
                $custom_link_after_last = '<span class="last page-numbers dsbl_link"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>';
                array_splice($pagination_links,$total_pages , 0, $custom_link_after_last);
            }
            $pagination_links[] = $last_page_link;

            echo '<div class="pagination">';
            foreach ($pagination_links as $link) {
                // Add the "active" class to the current page number
                $class = strpos($link, 'current') !== false ? ' active' : '';
                echo str_replace('page-numbers', 'page-numbers' . $class, $link);
            }
            echo '</div>';
        }

        return ob_get_clean();
    }


    public function count_correct_signals()
    {
        ob_start();
        $theposts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
            ),
        ));

        $posts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'incorrect'
                ),

            ),
        ));
//        $posts = get_posts('post_type=signals&suppress_filters=0&posts_per_page=-1');
        $totalPostcount = count($posts);
        $correctPost = count($theposts);
        $percentage = ($correctPost / $totalPostcount) * 100;
        $percentage = round($percentage, 2);
        include dirname(__FILE__) . '/partials/trade-fish-dashboard-text-data.php';

        return ob_get_clean();

    }


    public function count_correct_signals_circular()
    {
        ob_start();
        $theposts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
            ),
        ));
        $posts = get_posts(array(
            'post_type' => 'signals',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'correct'
                ),
                array(
                    'key' => '_signal_result',
                    'compare' => '=',
                    'value' => 'incorrect'
                ),

            ),
        ));
//        $posts = get_posts('post_type=signals&suppress_filters=0&posts_per_page=-1');
        $totalPostcount = count($posts);
        $correctPost = count($theposts);
        $percentage = ($correctPost / $totalPostcount) * 100;
        $percentage = round($percentage, 2);
        include dirname(__FILE__) . '/partials/trade-fish-dashboard-circular-data.php';

        return ob_get_clean();

    }

    public function bar_chart()
    {

        return '<div class="line_graph_heading"><h3 >Signals Generated</h3><div id="line-chart">
</div></div>';


    }

    public function get_currencies()
    {

        $currencies = array(
            'CHF' => '₣', // Swiss Franc
            'JPY' => '¥', // Japanese Yen
            'GBP' => '£', // British Pound Sterling
            'CAD' => 'C$', // Canadian Dollar
            'AUD' => 'A$', // Australian Dollar
            'NZD' => 'NZ$', // New Zealand Dollar
            'SGD' => 'S$', // Singapore Dollar
            'DKK' => 'kr', // Danish Krone
            'NOK' => 'kr', // Norwegian Krone
            'USD' => '$', // US Dollar
            'EUR' => '€', // Euro
        );

        return $currencies;
    }

    public function line_chart()
    {

        return '<div class="circle_multi_chart_heading"><div class="multi-chart-title"><h3>Signals Generated</h3><h4>(Last 365 Days)</h4></div><div id="chart"></div></div>';

    }
}
