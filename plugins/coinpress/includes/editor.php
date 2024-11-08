<div class="crypto-edit">

    <div class="crypto-options">

        <div class="fas crypto-collapse"></div>

        <div class="crypto-rows">
            <div class="crypto-cols crypto-labels">
                <label for="title"><?php _e("Widget Title", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <input type="text" class="selectize-input post-title" name="post_title" id="title" value="<?php echo esc_html(get_the_title()); ?>" />
            </div>
        </div>

        <div class="crypto-rows widget-type">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_ticker"><?php _e("Widget Type", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <label for="crypto_ticker1" class="form-radio">
                    <input type="radio" class="beaut-radio" name="type" id="crypto_ticker1" value="table" <?php if ($options['type'] == 'table') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Table", "coinpress"); ?>
                </label>
                <label for="crypto_ticker3" class="form-radio">
                    <input type="radio" class="beaut-radio" name="type" id="crypto_ticker3" value="global" <?php if ($options['type'] == 'global') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Global", "coinpress"); ?>
                </label>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle global-position<?php if ($options['type'] !== 'global') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_ticker_position"><?php _e("Position", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols no-padding" style="display: flex;">
                <label for="global_position1" class="form-radio global-position-label<?php if ($options['global_position'] == 'header') { echo ' selected'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_position" id="global_position1" value="header" <?php if ($options['global_position'] == 'header') { echo ' checked'; } ?> />
                    <img src="<?php echo COINMC_URL; ?>/assets/admin/img/card1.png" alt="">
                    <img class="hover-img" src="<?php echo COINMC_URL; ?>/assets/admin/img/card1hover.png" alt="">
                </label>
                <label for="global_position2" class="form-radio global-position-label<?php if ($options['global_position'] == 'footer') { echo ' selected'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_position" id="global_position2" value="footer" <?php if ($options['global_position'] == 'footer') { echo ' checked'; } ?> />
                    <img src="<?php echo COINMC_URL; ?>/assets/admin/img/card2.png" alt="">
                    <img class="hover-img" src="<?php echo COINMC_URL; ?>/assets/admin/img/card2hover.png" alt="">
                </label>
                <label for="global_position3" class="form-radio global-position-label<?php if ($options['global_position'] == 'same') { echo ' selected'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_position" id="global_position3" value="same" <?php if ($options['global_position'] == 'same') { echo ' checked'; } ?> />
                    <img src="<?php echo COINMC_URL; ?>/assets/admin/img/card3.png" alt="">
                    <img class="hover-img" src="<?php echo COINMC_URL; ?>/assets/admin/img/card3hover.png" alt="">
                </label>
            </div>
        </div>

        <div class="crypto-rows crypto-radio crypto-toggle global-position<?php if ($options['type'] !== 'global') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_global_color"><?php echo _e("Color", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols no-padding">
                <label data-tooltip="<?php _e("White", "coinpress"); ?>" for="global_color1" class="dark-check form-radio<?php if ($options['global_color'] == 'white') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color1" value="white" <?php if ($options['global_color'] == 'white') { echo 'checked'; } ?> /><span style="background: #fff;"></span>
                </label>
                <label data-tooltip="<?php _e("Red", "coinpress"); ?>" for="global_color2" class="form-radio<?php if ($options['global_color'] == 'crimson') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color2" value="crimson" <?php if ($options['global_color'] == 'crimson') { echo 'checked'; } ?> /><span style="background: #f00;"></span>
                </label>
                <label data-tooltip="<?php _e("Midnight", "coinpress"); ?>" for="global_color3" class="form-radio<?php if ($options['global_color'] == 'midnight') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color3" value="midnight" <?php if ($options['global_color'] == 'midnight') { echo 'checked'; } ?> /><span style="background: #000;"></span>
                </label>
                <label data-tooltip="<?php _e("Green", "coinpress"); ?>" for="global_color4" class="dark-check form-radio<?php if ($options['global_color'] == 'green') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color4" value="green" <?php if ($options['global_color'] == 'green') { echo 'checked'; } ?> /><span style="background: #0f0;"></span>
                </label>
                <label data-tooltip="<?php _e("Blue", "coinpress"); ?>" for="global_color5" class="form-radio<?php if ($options['global_color'] == 'blue') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color5" value="blue" <?php if ($options['global_color'] == 'blue') { echo 'checked'; } ?> /><span style="background: #00f;"></span>
                </label>
                <label data-tooltip="<?php _e("Custom Colors", "coinpress"); ?>" for="global_color6" class="custom-color form-radio<?php if ($options['global_color'] == 'custom') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="global_color" id="global_color6" value="custom" <?php if ($options['global_color'] == 'custom') { echo 'checked'; } ?> /><span></span>
                </label>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_ticker_coin"><?php _e("Coins", "coinpress"); ?> <a class="removecoins" style="float: right;"><?php _e("Clear", "coinpress"); ?></a></label>
            </div>

            <div class="crypto-cols">
                <select id="select-beast" name="coins[]" multiple>
                    <option value=""><?php _e("Select coin(s)", "coinpress"); ?></option>
                    <?php
                    $coinsyms = $this->coinsyms();
                    $coins = array_intersect($options['coins'], array_keys($coinsyms));
                    $remaining = array_diff_key($coinsyms, $coins);

                    foreach($coins as $coin) {
                        echo '<option value="' . $coin . '" selected data-extra=\'{ "symbol": "' . strtolower($coinsyms[$coin]['symbol']) . '" }\'>' . $coinsyms[$coin]['name'] . '</option>';
                    }
                    foreach($remaining as $key => $value) {
                        echo '<option value="' . $key . '" data-extra=\'{ "symbol": "' . strtolower($value['symbol']) . '" }\'>' . $value['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <br><br>

            <div class="crypto-cols">
                <?php _e("or show top"); ?> <select name="numcoins" id="" class="selectize-select" style="width: 10ch;">
                    <option value=""<?php if (intval($options['numcoins']) == 0) { echo ' selected'; } ?>></option>
                    <option value="5"<?php if (intval($options['numcoins']) == 5) { echo ' selected'; } ?>>5</option>
                    <option value="10"<?php if (intval($options['numcoins']) == 10) { echo ' selected'; } ?>>10</option>
                    <option value="50"<?php if (intval($options['numcoins']) == 50) { echo ' selected'; } ?>>50</option>
                    <option value="100"<?php if (intval($options['numcoins']) == 100) { echo ' selected'; } ?>>100</option>
                    <option value="200"<?php if (intval($options['numcoins']) == 200) { echo ' selected'; } ?>>200</option>
                    <option value="500"<?php if (intval($options['numcoins']) == 500) { echo ' selected'; } ?>>500</option>
                    <option value="1000"<?php if (intval($options['numcoins']) == 1000) { echo ' selected'; } ?>>1000</option>
                    <option value="2000"<?php if (intval($options['numcoins']) == 2000) { echo ' selected'; } ?>>2000</option>
                    <option value="<?php echo sizeof($coinsyms); ?>"<?php if (intval($options['numcoins']) > 2000) { echo ' selected'; } ?>><?php echo sizeof($coinsyms); ?></option>
                </select> <?php _e("coins", "coinpress"); ?>
            </div>
        </div>

        <div class="crypto-rows widget-type crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_ticker"><?php _e("Table Type", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <label for="table_type1" class="form-radio">
                    <input type="radio" class="beaut-radio" name="table_type" id="table_type1" value="simple" <?php if ($options['table_type'] == 'simple') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Simple", "coinpress"); ?>
                </label>
                <label for="table_type2" class="form-radio">
                    <input type="radio" class="beaut-radio" name="table_type" id="table_type2" value="advanced" <?php if ($options['table_type'] == 'advanced') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Advanced", "coinpress"); ?>
                </label>
            </div>
        </div>

        <div class="crypto-rows crypto-radio crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_table_style"><?php echo __("Table", "coinpress") . " " . __("Style", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols no-padding">
                <label data-tooltip="<?php _e("Light", "coinpress"); ?>" for="table_style1" class="dark-check form-radio<?php if ($options['table_style'] == 'light') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="table_style" id="table_style1" value="light" <?php if ($options['table_style'] == 'light') { echo 'checked'; } ?> /><span style="background: #fff;"></span>
                </label>
                <label data-tooltip="<?php _e("Dark", "coinpress"); ?>" for="table_style2" class="form-radio<?php if ($options['table_style'] == 'dark') { echo ' cc-active'; } ?>">
                    <input type="radio" class="beaut-radio" name="table_style" id="table_style2" value="dark" <?php if ($options['table_style'] == 'dark') { echo 'checked'; } ?> /><span style="background: #333;"></span>
                </label>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="table_length"><?php _e("Coins Per Page", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols range-slider">
                    <input name="table_length" id="table_length" class="range-slider__range" type="range" step="5" value="<?php echo $options['table_length']; ?>" min="5" max="200">
                    <span class="range-slider__value" data-suffix=""><?php echo $options['table_length']; ?></span>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="table_length"><?php echo __("Table", "coinpress") . " " . __("Columns", "coinpress"); ?> <a class="removecols" style="float: right;"><?php _e("Clear", "coinpress"); ?></a></label>
            </div>
            <div class="crypto-cols">
                <select id="coinmc_tablecols" name="table_columns[]" multiple>

                    <?php
                    
                        $fields = ['no', 'rank', 'name', 'symbol', 'price_usd', 'price_btc', 'market_cap_usd', 'volume_usd_24h', 'available_supply', 'total_supply', 'percent_change_1h', 'percent_change_24h', 'percent_change_7d', 'percent_change_30d', 'last24h', 'weekly', 'actions'];

                        $colnames = [
                            "no" => __("#", "coinpress"),
                            "rank" => __("Rank", "coinpress"),
                            "name" => __("Coin", "coinpress"),
                            "symbol" => __("Symbol", "coinpress"),
                            "price_usd" => __("Price", "coinpress"),
                            "price_btc" => __("Price (BTC)", "coinpress"),
                            "market_cap_usd" => __("Marketcap", "coinpress"),
                            "volume_usd_24h" => __("Volume (24h)", "coinpress"),
                            "available_supply" => __("Supply", "coinpress"),
                            "total_supply" => __("Total Supply", "coinpress"),
                            "percent_change_1h" => __("Change (1H)", "coinpress"),
                            "percent_change_24h" => __("Change (24H)", "coinpress"),
                            "percent_change_7d" => __("Change (7D)", "coinpress"),
                            "percent_change_30d" => __("Change (30D)", "coinpress"),
                            "last24h" => __("Price Graph (24h)", "coinpress"),
                            "weekly" => __("Price Graph (7D)", "coinpress"),
                            "actions" => __('Actions', "coinpress")
                        ];

                        $remaining = array_diff($fields, $options['table_columns']);

                        foreach($options['table_columns'] as $column) {
                            echo '<option value="' . $column . '" selected>' . $colnames[$column] . '</option>';
                        }
                        foreach($remaining as $rem) {
                            echo '<option value="' . $rem . '">' . $colnames[$rem] . '</option>';
                        }

                    ?>
                </select>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="table_order"><?php _e("Order By", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <div class="crypto-cols-half">
                    <select name="table_order" id="table_order" class="selectize-select">
                        <option value="slug"<?php if ($options['table_order'] == 'slug') { echo ' selected'; } ?>><?php _e('Default', "coinpress"); ?></option>
                        <option value="name"<?php if ($options['table_order'] == 'name') { echo ' selected'; } ?>><?php _e('Coin', "coinpress"); ?></option>
                        <option value="rank"<?php if ($options['table_order'] == 'rank') { echo ' selected'; } ?>><?php _e('Rank', "coinpress"); ?></option>
                        <option value="market_cap_usd"<?php if ($options['table_order'] == 'market_cap_usd') { echo ' selected'; } ?>><?php _e('Marketcap', "coinpress"); ?></option>
                        <option value="price_usd"<?php if ($options['table_order'] == 'price_usd') { echo ' selected'; } ?>><?php _e('Price', "coinpress"); ?></option>
                        <option value="volume_usd_24h"<?php if ($options['table_order'] == 'volume_usd_24h') { echo ' selected'; } ?>><?php _e('Volume', "coinpress"); ?></option>
                        <option value="percent_change_1h"<?php if ($options['table_order'] == 'percent_change_1h') { echo ' selected'; } ?>><?php _e('Change (1H)', "coinpress"); ?></option>
                        <option value="percent_change_24h"<?php if ($options['table_order'] == 'percent_change_24h') { echo ' selected'; } ?>><?php _e('Change (24H)', "coinpress"); ?></option>
                        <option value="percent_change_7d"<?php if ($options['table_order'] == 'percent_change_7d') { echo ' selected'; } ?>><?php _e('Change (7D)', "coinpress"); ?></option>
                        <option value="percent_change_30d"<?php if ($options['table_order'] == 'percent_change_30d') { echo ' selected'; } ?>><?php _e('Change (30D)', "coinpress"); ?></option>
                    </select>
                </div>
                <div class="crypto-cols-half">
                    <select name="table_order_dir" id="table_order_dir" class="selectize-select">
                        <option value="asc"<?php if ($options['table_order_dir'] == 'asc') { echo ' selected'; } ?>><?php _e('Low to High', "coinpress"); ?></option>
                        <option value="desc"<?php if ($options['table_order_dir'] == 'desc') { echo ' selected'; } ?>><?php _e('High to Low', "coinpress"); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="crypto-rows widget-type crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_ticker"><?php _e("Responsive Type", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <label for="table_restype1" class="form-radio">
                    <input type="radio" class="beaut-radio" name="table_restype" id="table_restype1" value="scroll" <?php if ($options['table_restype'] == 'scroll') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Scroll", "coinpress"); ?>
                </label>
                <label for="table_restype2" class="form-radio">
                    <input type="radio" class="beaut-radio" name="table_restype" id="table_restype2" value="collapse" <?php if ($options['table_restype'] == 'collapse') { echo 'checked'; } ?> /><i class="form-icon"></i> <?php _e("Collapse", "coinpress"); ?>
                </label>
            </div>
        </div>

        <div class="crypto-rows">
            <div class="crypto-cols crypto-labels">
                <label for="real_time"><?php _e("Options", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <span class="crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
                    <label for="settings1" class="form-switch">
                        <input type="checkbox" name="settings[]" id="settings1" value="realtime"<?php if(is_array($options['settings']) && in_array('realtime', $options['settings'])) { echo ' checked'; } ?> /><i class="form-icon"></i><?php _e("Real Time", "coinpress"); ?>
                    </label>
                </span>
                <span class="crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
                    <label class="form-switch" for="settings2">
                        <input type="checkbox" name="settings[]" id="settings2" value="linkto"<?php if (is_array($options['settings']) && in_array('linkto', $options['settings'])) { echo " checked"; } ?> />
                        <i class="form-icon"></i><?php _e("Link to coin pages", "coinpress"); ?>
                    </label>
                </span>
                <span class="crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
                    <label class="form-switch" for="settings3">
                        <input type="checkbox" name="settings[]" id="settings3" value="fixedcol"<?php if (is_array($options['settings']) && in_array('fixedcol', $options['settings'])) { echo " checked"; } ?> />
                        <i class="form-icon"></i><?php _e("Fixed Columns", "coinpress"); ?>
                    </label>
                </span>
                <span class="crypto-toggle table-position<?php if ($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
                    <label class="form-switch" for="settings4">
                        <input type="checkbox" name="settings[]" id="settings4" value="fixedhead"<?php if (is_array($options['settings']) && in_array('fixedhead', $options['settings'])) { echo " checked"; } ?> />
                        <i class="form-icon"></i><?php _e("Fixed Header", "coinpress"); ?>
                    </label>
                </span>
                <span class="crypto-toggle global-position<?php if ($options['type'] !== 'global') { echo ' cc-hide'; } ?>">
                    <label class="form-switch" for="settings5">
                        <input type="checkbox" name="settings[]" id="settings5" value="rounded"<?php if(is_array($options['settings']) && in_array('rounded', $options['settings'])) { echo " checked"; } ?> />
                        <i class="form-icon"></i><?php _e("Rounded", "coinpress"); ?>
                    </label>
                </span>
            </div>
        </div>

        <div class="crypto-rows">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_price_format"><?php _e("Marketcap Price Format", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <select id="price-format" name="price_format"  class="selectize-select">
                    <option value="1"<?php if ($options['price_format'] == '1') { echo ' selected'; } ?>><?php _e("Symbol", "coinpress"); ?> ($ 156 B)</option>
                    <option value="3"<?php if ($options['price_format'] == '3') { echo ' selected'; } ?>><?php _e("Numbers", "coinpress"); ?> ($ 156,422,421,202)</option>
                </select>
            </div>
        </div>

        <div class="crypto-rows">
            <div class="crypto-cols crypto-labels">
                <label for="crypto_currency_fiat"><?php _e("Currency", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <select id="mcw-currencies" name="currency" class="selectize-select">
                    <?php $currencies = $this->get_currencies();
                    foreach($currencies as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"<?php if ($key == $options['currency']) { echo ' selected'; } ?>><?php echo $key; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="crypto-rows crypto-toggle table-position<?php if($options['type'] !== 'table') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
                <label for="chart_color"><?php _e("Chart Color", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
                <input type="text" name="chart_color" value="<?php echo $options['chart_color']; ?>" class="selectize-input color-field">
            </div>
        </div>

        <div class="crypto-rows crypto-toggle global-position<?php if($options['type'] !== 'global') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
				<label for="text_color"><?php _e("Custom Text Color", "coinpress"); ?></label>
			</div>
			<div class="crypto-cols">
                <input type="text" name="text_color" value="<?php echo $options['text_color']; ?>" class="selectize-input color-field" data-alpha="true">
			</div>
        </div>

        <div class="crypto-rows crypto-toggle global-position<?php if($options['type'] !== 'global') { echo ' cc-hide'; } ?>">
            <div class="crypto-cols crypto-labels">
				<label for="background_color"><?php _e("Custom Background Color", "coinpress"); ?></label>
            </div>
            <div class="crypto-cols">
				<input type="text" name="background_color" value="<?php echo $options['background_color']; ?>" class="selectize-input color-field" data-alpha="true">
			</div>
        </div>

    </div>

    <div class="crypto-preview">
        <div class="crypto-notice"><span class="fas fa-info-circle"></span> <?php _e("Publish or update to preview", "coinpress"); ?></div>
        <div class="crypto-affix">
            <?php echo do_shortcode('[coinmc id="'.$post->ID.'"]'); ?>
        </div>
    </div>

</div>