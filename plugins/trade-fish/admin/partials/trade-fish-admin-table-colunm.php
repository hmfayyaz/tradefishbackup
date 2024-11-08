<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin post type table colunms aspects of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/admin/partials
 */
?>
<div class="signal_r">Signal Result:</div>
<div class="_signal_values" style="display:flex;">

    <div class="ticker_signal_details">
        <input type="radio" id="correct_<?= $post_id ?>" class="status_radio" data-sec="closing_price_<?php echo $post_id;  ?>" name="signal_result_<?= $post_id ?>"
               value="correct" <?php if ($signal_result === 'correct') {
            echo 'checked';
        } ?>>
        <label for="correct_<?= $post_id ?>">Correct</label>
        <input type="radio" id="incorrect_<?= $post_id ?>"  class="status_radio"  data-sec="closing_price_<?php echo $post_id;  ?>" name="signal_result_<?= $post_id ?>"
               value="incorrect" <?php if ($signal_result === 'incorrect') {
            echo 'checked';
        } ?>>
        <label for="incorrect_<?= $post_id ?>">Incorrect</label>

        <input type="radio" id="hidden_<?= $post_id ?>" class="status_radio"  data-sec="closing_price_<?php echo $post_id;  ?>"  name="signal_result_<?= $post_id ?>"
               value="hidden" <?php if ($signal_result === 'hidden') {
            echo 'checked';
        } ?>>
        <label for="hidden_<?= $post_id ?>">Hidden</label>
        <input type="radio" id="unset_<?= $post_id ?>" class="status_radio" data-sec="closing_price_<?php echo $post_id;  ?>"  name="signal_result_<?= $post_id ?>"
               value="unset" <?php if ($signal_result === 'unset') {
            echo 'checked';
        } ?>>
        <label for="unset_<?= $post_id ?>">Unset</label>

        <div class="_closing_price_div <?php if($signal_result === 'correct' || $signal_result === 'incorrect' ){ echo '';}else{echo 'price_section_hide';} ?> " id="closing_price_<?php echo $post_id;  ?>">
            <h5>Closing Price:</h5>
            <input type="text" name="_closing_prize"  value="<?php if ($closing_prize != '') {
                echo $closing_prize;
            } ?>">
            <h5>Realized P/L:</h5>
            <input type="text" name="realized_profit_or_loss"  value="<?php if ($realized_profit_or_loss != '') {
                echo $realized_profit_or_loss;
            } ?>">
        </div>

        <input class='hidden' type="hidden" name="_post_id_<?= $post_id ?>" value="<?= $post_id ?>">
    </div>
    <div>
        <button type="button" class="signal_result_save_button update_ticker" data-id="<?= $post_id ?>">save</button>
    </div>

</div>
