<?php
namespace Elementor;
if (!defined('ABSPATH')) exit;
$title = (string)graphina_get_dynamic_tag_data($settings, 'iq_org_google_chart_heading');
$description = (string)graphina_get_dynamic_tag_data($settings, 'iq_org_google_chart_content');
if (isRestrictedAccess('org_google', $mainId, $settings, true)) {
    if ($settings['iq_org_google_restriction_content_type'] === 'password') {
        return true;
    }
    echo html_entity_decode($settings['iq_org_google_restriction_content_template']);
    return true;
}
?>


<style type='text/css'>
    #org_google_chart<?php esc_attr_e($mainId); ?> .myNodeClass {
        text-align: <?php echo $settings['iq_' . $type . '_google_chart_node_text_align']; ?>;
    }

    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-connrow-small,
    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-connrow-medium,
    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-connrow-large {
        height: <?php echo intval($settings['iq_' . $type . '_google_chart_node_conn_height']).'px';?>;
    }

    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-linebottom {
        border-bottom-width: <?php echo intval($settings['iq_' . $type . '_google_chart_node_conn_width']).'px';?>;
        border-bottom-style: <?php echo$settings['iq_' . $type . '_google_chart_node_conn_style']?>;
        border-bottom-color: <?php echo$settings['iq_' . $type . '_google_chart_node_conn_color']?>;
    }

    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-lineright {
        border-right-width: <?php echo intval($settings['iq_' . $type . '_google_chart_node_conn_width']).'px';?>;
        border-right-style: <?php echo $settings['iq_' . $type . '_google_chart_node_conn_style']?>;
        border-right-color: <?php echo $settings['iq_' . $type . '_google_chart_node_conn_color']?>;
    }

    #org_google_chart<?php esc_attr_e($mainId); ?> .google-visualization-orgchart-lineleft {
        border-left-width: <?php echo intval($settings['iq_' . $type . '_google_chart_node_conn_width']).'px';?>;
        border-left-style: <?php echo $settings['iq_' . $type . '_google_chart_node_conn_style']?>;
        border-left-color: <?php echo $settings['iq_' . $type . '_google_chart_node_conn_color']?>;
    }


</style>


<div class="<?php echo $settings['iq_org_google_chart_card_show'] === 'yes' ? 'chart-card' : ''; ?>">
    <div class="">
        <?php if ($settings['iq_org_google_is_card_heading_show'] && $settings['iq_org_google_chart_card_show']) { ?>
            <h4 class="heading graphina-chart-heading">
                <?php echo html_entity_decode($title); ?>
            </h4>
        <?php }
        if ($settings['iq_org_google_is_card_desc_show'] && $settings['iq_org_google_chart_card_show']) { ?>
            <p class="sub-heading graphina-chart-sub-heading">
                <?php echo html_entity_decode($description); ?>
            </p>
        <?php } ?>
    </div>
    <?php
    graphina_filter_common($this, $settings, $this->get_chart_type(),$mainId);
    ?>
    <div class="<?php echo $settings['iq_org_google_chart_border_show'] === 'yes' ? 'chart-box' : ''; ?>">
        <div class="<?php esc_attr_e($this->get_chart_type()); ?>-chart-<?php esc_attr_e($mainId); ?>" id='org_google_chart<?php esc_attr_e($mainId); ?>'
            style="<?php echo !empty($settings['iq_' . $type . '_chart_height']) ? 'min-height:'. $settings['iq_' . $type . '_chart_height'].'px;' : '';?>">
        </div>
    </div>
</div>





