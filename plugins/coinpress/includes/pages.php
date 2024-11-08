<?php


if (!defined('ABSPATH')) {
    exit;
}

class Pages {
    public $config;
    public $wpdb;
    public $tablename;
    public $dtablename;

    public function __construct($config) {
        global $wpdb;
        $this->config = $config;

        $this->wpdb = $wpdb;
        $this->tablename = $this->wpdb->base_prefix . "mcw_coins";
        $this->dtablename = $this->wpdb->base_prefix . "coinmc_details";

        add_action('init',                          array($this, 'rewrite_rules'));
        add_filter('display_post_states',           array($this, 'add_page_label'));
        add_action('template_redirect',             array($this, 'template_redirect'));
        add_filter('comment_post_redirect',         array($this, 'comment_post_redirect'), 10, 2);
        add_action('comment_post',	                array($this, 'save_comment_additional_field_data'));
        add_filter('body_class',                    array($this, 'add_single_page_class'));
    }

    public function is_coinpage(){
        global $wpdb, $post, $wp, $sitepress;
        if($sitepress){
            $default_language = $sitepress->get_default_language();
            $id = icl_object_id($post->ID, 'page', false, $default_language);
            return $id == $this->config['page'] || $post->ID == $this->config['page'] && $this->config['page'] != 0;
        }
        $output = isset($post) && ($post->ID == $this->config['page']) && $this->config['page'] != 0;

        return $output;
    }

    public function template_redirect() {
        if($this->is_coinpage()){
            // wordpress
            add_filter('the_title', array($this, 'add_page_title_loop'), 10, 2);
            add_filter('pre_get_document_title', array($this, 'add_page_title'), 10, 1);

            // yoast seo
            add_filter('wpseo_title', array($this, 'add_page_title'), 10, 1);
            add_filter('wpseo_opengraph_title', array($this, 'add_page_title'), 10, 1);
            add_filter('wpseo_metadesc', array($this, 'add_page_desc'), 10, 1);
            add_filter('wpseo_opengraph_desc', array($this, 'add_page_desc'), 10, 1);
            add_filter('wpseo_canonical', '__return_false', 10, 1);
            
            // the seo framework
            add_filter('the_seo_framework_title_from_custom_field', array($this, 'add_page_title'), 10, 1);
            add_filter('the_seo_framework_custom_field_description', array($this, 'add_page_desc'), 10, 1);
            add_filter('the_seo_framework_rel_canonical_output', '__return_false', 10, 1);

            // all in one seo
            add_filter('aioseop_title', array($this, 'add_page_title'), 10, 1);
            add_filter('aioseop_description', array($this, 'add_page_desc'), 10, 1);
            add_filter('aioseop_canonical_url', '__return_false', 10, 1);

            // seopress
            add_filter('seopress_titles_title', array($this, 'add_page_title'));
            add_filter('seopress_titles_desc', array($this, 'add_page_desc'));
            add_action('seopress_titles_canonical', '__return_false');

            // rank math
            add_filter('rank_math/frontend/title', array($this, 'add_page_title'));
            add_filter('rank_math/frontend/description', array($this, 'add_page_desc'));
            add_filter('rank_math/frontend/canonical', '__return_false', 10, 1);

            // Comment filters
            add_action('comment_form_logged_in_after',  array($this, 'comment_additional_fields'));
            add_action('comment_form_after_fields',     array($this, 'comment_additional_fields'));
            add_filter('the_comments',                  array($this, 'filter_comments_coinpage'), 20, 1);
            add_filter('get_comments_number',           array($this, 'filter_comments_count'), 20, 2);

            add_action('wp_head', array($this, 'add_page_meta'), 5);
        }
    }

    public function comment_additional_fields() {
        echo '<input type="hidden" name="coinpage" value="' . apply_filters('coinmc_virtual_asset', '') . '" />';
    }

    public function save_comment_additional_field_data( $comment_id ) {
        if(isset($_POST['coinpage']) && $_POST['coinpage'] != ''){
            add_comment_meta( $comment_id, 'coinpage', $_POST['coinpage']);
        }
    }

    public function filter_comments_coinpage($comments){
        if(!is_admin()){
            foreach($comments as $i => $comment){
                $coin = get_comment_meta( $comment->comment_ID, 'coinpage', true );
                $slug = apply_filters('coinmc_virtual_asset', '');
                if($coin != $slug){
                    unset($comments[$i]);
                }
            }
        }
        return $comments;
    }
    
    public function filter_comments_count($count, $post_id){
        if(!is_admin()){
            $comments = get_comments(['post_id' => $post_id]);
            foreach($comments as $i => $comment){
                $coin = get_comment_meta( $comment->comment_ID, 'coinpage', true );
                $slug = apply_filters('coinmc_virtual_asset', '');
                if($coin != $slug){
                    unset($comments[$i]);
                }
            }
            return count($comments);
        }
    }

    public function comment_post_redirect($location, $comment) {
        if ($this->config['page'] === intval($comment->comment_post_ID)) {
            $qcoin = apply_filters('coinmc_virtual_asset', '') != '' ? apply_filters('coinmc_virtual_asset', '') : $_POST['coinpage'];
            $location = $this->get_link($qcoin, $this->config) . "#comment-".$comment->comment_ID;
        }
        return $location;
    }

    public function add_single_page_class($classes) {
        if($this->is_coinpage()){
            $classes[] = 'coinpage';
            $classes[] = 'coingrid';
        }
        return $classes;
    }

    public function add_page_label($states) {
        global $post, $typenow;
        if($typenow != 'page') { return $states;}

        if($this->is_coinpage()){
            return $states[] = array('Coinpress');
        }
        return $states;
    }

    public function add_page_title($title) {
        $title = wp_kses(do_shortcode($this->config['title']), array());
        return $title;
    }

    public function add_page_title_loop($title, $id = null) {
        if (in_the_loop() && $this->is_coinpage() && $id == $this->config['page']) {
            $title = wp_kses(do_shortcode($this->config['title']), array());
        }
        return $title;
    }

    public function add_page_desc($desc) {
        $desc = wp_kses(do_shortcode($this->config['description']), array());
        return $desc;
    }

    public function add_page_meta() {
        global $post;

        if ($post == null) {
            return;
        }

        $qcoin = apply_filters('coinmc_virtual_asset', '');

        if ($qcoin && $this->is_coinpage()) {
            global $wp;

            remove_action('wp_head', 'rel_canonical');

            $qcoin = apply_filters('coinmc_virtual_asset', '');
            $permalink = $this->get_link($qcoin, $this->config);
            $coin = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->tablename}` WHERE `slug` = %s", $qcoin));
            $permalink = apply_filters('coinmc_canonical_link', trailingslashit(site_url($permalink)));
            $head = "<link rel=\"canonical\" href=\"" . $permalink . "\" />\n";

            if (!defined('WPSEO_VERSION') && !defined('THE_SEO_FRAMEWORK_VERSION') && !defined('AIOSEOP_VERSION') && !defined('SEOPRESS_VERSION')) {
                $head .= "<meta property=\"og:description\" content=\"" . $this->get_meta_desc($qcoin) . "\" />\n";
                $head .= "<meta property=\"og:title\" content=\"" . wp_kses(get_the_title(), array()) . "\" />\n";
                $head .= "<meta property=\"og:type\" content=\"article\" />\n";
                $head .= "<meta property=\"og:site_name\" content=\"" . get_bloginfo('name') . "\"/>\n";
            }

            $head .= "<meta property=\"og:image\" content=\"" . $coin->img . "\" />\n";
            $head .= "<meta property=\"og:url\" content=\"" . home_url($wp->request) . "\" />\n";
            echo $head;
        }
    }

    public function get_meta_desc($qcoin) {

        $details = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->dtablename}` WHERE `slug` = %s", $qcoin));

        if ($details === null) {
            return;
        }

        if (!empty($details->meta_description)) {
            return wp_kses(do_shortcode(stripslashes($details->meta_description)), array());
        } else if (!empty($this->config['meta_description'])) {
            return wp_kses(do_shortcode($this->config['meta_description']), array());
        } else if (!empty($details->description)) {
            return wp_kses(do_shortcode(stripslashes($details->description)), array());
        } else if (!empty($this->config['description'])) {
            return wp_kses(do_shortcode($this->config['description']), array());
        }

        return;
    }

    public function rewrite_rules() {
        if (!empty($this->config['link'])) {
            $link = str_replace(site_url(), '', $this->config['link']);
            $link = ltrim($link, '/');
            $regex = '^' . str_replace('[symbol]', '([a-zA-Z0-9-_\.=\^\$]+)', $link) . '?$';

            add_rewrite_rule($regex, 'index.php?page_id=' . $this->config['page'], 'top');

            if (!get_option('coinmc_permalinks_flushed')) {
                flush_rewrite_rules(false);
                update_option('coinmc_permalinks_flushed', 1);
            }
        }
    }

    
    public function get_link($slug, $config){
        $link = esc_url(str_replace('[symbol]', strtolower($slug), $config['link']));
        return $link;
    }

}