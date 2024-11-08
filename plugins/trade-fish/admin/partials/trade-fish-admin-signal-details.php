<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin meta box signal details aspects of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/admin/partials
 */


?>

<div class="ticker_type_div">
    <label for="ticker_type" ">Ticker Type:</label>
    <select name="ticker_type" class="ticker_type">
        <option value="0">Select Type</option>
        <option value="crypto" <?php echo $ticker_type != '' && $ticker_type == 'crypto'? 'selected':''; ?>>Crypto</option>
        <option value="stocks" <?php echo $ticker_type != '' && $ticker_type == 'stocks'? 'selected':''; ?>>Stocks</option>
        <option value="commodities" <?php echo $ticker_type != '' && $ticker_type == 'commodities'? 'selected':''; ?>>Commodities</option>
        <option value="fx" <?php echo $ticker_type != '' && $ticker_type == 'fx'? 'selected':''; ?>>FX</option>
        <option value="indices"<?php echo $ticker_type != '' && $ticker_type == 'indices'? 'selected':''; ?>>Indices</option>
    </select>
</div>

<div class="confidence_div">
    <label for="confidence">Confidence:</label>
    <input type="text" id="confidence" name="confidence" value="<?php if ($confidence != '') {
        echo $confidence;
    } ?>" style="width: 50%;">
</div>


<div class="signal_div">
    <label for="market_signal">Signal value</label>


    <div class="input_signal_value">
        <input type="radio" id="short" name="signal_value" value="short" <?php if ($signal_value === 'short') {
            echo 'checked';
        } ?>>
        <label for="short">Short:</label>

        <input type="radio" id="long" name="signal_value" value="long" <?php if ($signal_value === 'long') {
            echo 'checked';
        } ?>>
        <label for="long">Long:</label>

        <input type="radio" id="pending" name="signal_value" value="pending" <?php if ($signal_value === 'pending') {
            echo 'checked';
        } ?>>
        <label for="pending">Pending:</label>
    </div>

</div>


<div class="opening_price_div">
    <label for="opening_price">Opening Price:</label>
    <input type="text" id="opening_price" name="opening_price" value="<?php if ($opening_price != '') {
        echo $opening_price;
    } ?>" style="width: 50%;">
</div>


<div class="currency_div">
    <label for="currency">Currency:</label>
    <!-- <input type="number" id="currency" name="currency" value="" style="width: 50%;"> -->
    <select name="currency" id="currency">
        <?php
        foreach($currencies as $key => $row){
        ?>
        <option value="<?php echo $key; ?>" <?php if ($currency === $key) {
            echo 'selected';
        } ?>><?php echo $key; ?>
        </option>
        <?php } ?>
    </select>
</div>

<div class="expected_position_holding-div">
    <label for="expected_position_holding" >Expected Position Holding:</label>
    <select name="expected_position_holding" class="expected_position_holding">
        <option value="0">Select Position</option>
        <option value="short_term" <?php echo $expected_position_holding != '' && $expected_position_holding == 'short_term'? 'selected':''; ?>>Short-term</option>
        <option value="medium_term" <?php echo $expected_position_holding != '' && $expected_position_holding == 'medium_term'? 'selected':''; ?>>Medium-term</option>
        <option value="long_term" <?php echo $expected_position_holding != '' && $expected_position_holding == 'long_term'? 'selected':''; ?>>Long-term</option>
    </select>
</div>

<div class="risk_label_div">
    <label for="risk_label" >Risk Label:</label>
    <select name="risk_label" class="risk_label">
        <option value="0">Select Label</option>
        <option value="low_risk" <?php echo $risk_label != '' && $risk_label == 'low_risk'? 'selected':''; ?>>Low Risk</option>
        <option value="mid_risk" <?php echo $risk_label != '' && $risk_label == 'mid_risk'? 'selected':''; ?>>Medium Risk</option>
        <option value="high_risk" <?php echo $risk_label != '' && $risk_label == 'high_risk'? 'selected':''; ?>>High Risk</option>
    </select>
</div>

<br>
<br>

<div class="ticker_post_div">
    <label for="post_on_twitter">Post On Twitter:</label>
    <input type="checkbox" id="post_on_twitter" name="post_on_twitter" value="1" <?php if ($post_on_twitter != '') {
        echo 'checked';
    } ?>>
    <label for="post_on_telegram">Post On Telegram:</label>
    <input type="checkbox" id="post_on_telegram" name="post_on_telegram" value="1" <?php if ($post_on_telegram != '') {
        echo 'checked';
    } ?>>
</div>
<div class="ai_model_drop_down_div">
    <label for="ai_model_drop_down"><b>AI MODEL:</b></label>
    <select name="ai_model_drop_down" id="ai_model_drop_down" style="width:100%">
        <option>Select AI Model</option>

        <?php
        // Assuming $ai_models and $selected_ai_model are defined and passed to this part of the code
        if ($ai_models->have_posts()) {
            while ($ai_models->have_posts()) {
                $ai_models->the_post();
                $selected = (get_the_ID() == $selected_ai_model) ? 'selected' : '';
                echo '<option value="' . esc_attr(get_the_ID()) . '" ' . $selected . '>' . esc_html(get_the_title()) . '</option>';
            }
            wp_reset_postdata();
        }
        ?>
    </select>
</div>

<div class="ai_model_drop_down_div mt-3">
    <label for="trading_referral_drop_down"><b>Trading Platform:</b></label>
    <select name="trading_referral_drop_down" id="trading_referral_drop_down" style="width:100%">
        <option>Select Trading Platform</option>

        <?php
        // Assuming $ai_models and $selected_ai_model are defined and passed to this part of the code
        if ($trading_referral->have_posts()) {
            while ($trading_referral->have_posts()) {
                $trading_referral->the_post();
                $selected = (get_the_ID() == $selected_trading_referral) ? 'selected' : '';
                echo '<option value="' . esc_attr(get_the_ID()) . '" ' . $selected . '>' . esc_html(get_the_title()) . '</option>';
            }
            wp_reset_postdata();
        }
        ?>
    </select>
</div>


<div class="advice_text_div">
    <label for="advise_text">Advise text:</label>
    <textarea id="advise_text" name="advise_text" rows="6" cols="50" style="width: 100%;"><?php if ($advise_text != '') {
            echo $advise_text;
        }else{
        echo 'We advise users to not use any leverage unless they are very proficient traders' ;
        } ?></textarea>
</div>



