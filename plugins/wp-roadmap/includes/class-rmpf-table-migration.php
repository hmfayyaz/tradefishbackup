<?php
class RMPF_Table_Migration {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since   1.0.7
     */

    /**Feedback Table Migration*/
    public static function rmpf_migrate_feedback() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'feedback';
        $sql = "CREATE TABLE $table_name (
            id  bigint(20) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            description longtext NOT NULL,
            UNIQUE KEY id (id),
            status_id  bigint(20) NOT NULL,
            sequence_order int(11) NOT NULL,
            total_upvote bigint(20) NOT NULL,
            created_date date NOT NULL
        )$charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        //Insert Default Data in Table.
        $result = $wpdb->get_results("SELECT id from $table_name WHERE `id` IS NOT NULL");
        if(count($result) == 0) {
            //Insert data in table
            $wpdb->query("INSERT INTO $table_name (title,description,status_id,sequence_order)VALUES('Pending-Task1','pending',1,1)");
            $wpdb->query("INSERT INTO $table_name (title,description,status_id,sequence_order)VALUES('Progress-Task1','progress',2,1)");
            $wpdb->query("INSERT INTO  $table_name (title,description,status_id,sequence_order)VALUES('Complete-Task1','complete',3,1)");
        }
    }
    /**Up Vote Table Migration*/
    public static function rmpf_migrate_upvote() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'feedback_upvote';
        $sql = "CREATE TABLE $table_name (
            id  bigint(20) NOT NULL AUTO_INCREMENT,
            visitor_ip_address longtext NOT NULL,
            UNIQUE KEY id (id),
            feedback_id  bigint(20) NOT NULL
        )$charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    /**Feedback Status Table Migration*/
    public static function rmpf_migrate_feedback_status(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'feedback_status';
        $sql = "CREATE TABLE $table_name (
            id  bigint(20) NOT NULL AUTO_INCREMENT,
            title longtext NOT NULL,
            color longtext NOT NULL,
            active_status int(11) NOT NULL DEFAULT '1' ,
            sequence_order int(11) NOT NULL,
            UNIQUE KEY id (id),
            sequence  bigint(20) NOT NULL
        )$charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

         //Insert Default Data in Table.
         $result = $wpdb->get_results("SELECT id from $table_name WHERE `id` IS NOT NULL");
         if(count($result) == 0) {
            // Insert data in table
            $wpdb->query("INSERT INTO $table_name (title,color,active_status,sequence_order)VALUES('Pending','#e7213b',1,1)");
            $wpdb->query("INSERT INTO $table_name (title,color,active_status,sequence_order)VALUES('Progress','#ffff33 ',1,2)");
            $wpdb->query("INSERT INTO $table_name (title,color,active_status,sequence_order)VALUES('Complete','#86ff33 ',1,3)");
         }
    }

    /**Set Default Value In wp_options Table */
    public static function wp_general_setting_default_options () {
        $default = array(
            'title'     => 'Your Site Title',
            'description'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            'wp_roadmap_status'=>'newest',
            'suggestion'=>'Your Suggestion',
            'request_feature_link' => "",
            'pages'=>[]

        );
        update_option( 'wp_feedback_roadmap_general_settings', $default );
    }
}