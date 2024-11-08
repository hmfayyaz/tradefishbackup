<?php

if (!defined('ABSPATH')) { exit; }

if (!class_exists('Coinmarketcap_Shortcodes')) {

    class Coinmarketcap_Shortcodes {

        public $config;
        protected $tabscontent;

        public function __construct($tabscontent = '') {
            $this->tabscontent = $tabscontent;
        }

        public function number_format($number, $currency = 'USD', $shorten = false, $decimals = 'auto') {
            $number = abs($number);
            $currency_formats = array_column($this->config['currency_format'], null, 'iso');
            $format = isset($currency_formats[$currency]) ? $currency_formats[$currency] : $this->config['default_currency_format'];

            if ($shorten) {                            
                $decimals = $format['decimals'];
            } else if ($decimals === 'auto') {
                $decimals = ($number >= 1) ? $format['decimals'] : ($number < 0.000001 ? 14 : 6);
            } else {
                $decimals = intval($decimals);
            }

            $index = 0;
            $suffix = '';
            $suffixes = array("", " K", " M", " B", " T");

            if ($shorten) {
                while ($number > 1000) {
                    $number = $number / 1000;
                    $index++;
                }
                $suffix = $suffixes[$index];
            }

            return number_format($number, $decimals, $format['decimals_sep'], $format['thousands_sep']) . $suffix;
        }

        public function price_format($price, $rate = 1, $currency = 'USD', $shorten = false, $decimals = 'auto') {
            $price = ($currency === 'BTC') ? abs($price / $rate) : abs($price * $rate);
            $currency_formats = array_column($this->config['currency_format'], null, 'iso');
    
            $format = isset($currency_formats[$currency]) ? $currency_formats[$currency] : $this->config['default_currency_format'];
            $price = $this->number_format($price, $currency, $shorten, $decimals);
            $price = (($price < 1 && $price != 0) ? rtrim($price, '0') : $price);

            $out = $format['position'];
            $out = str_replace('{symbol}', '<b class="fiat-symbol">' . $format['symbol'] . '</b>', $out);
            $out = str_replace('{space}', ' ', $out);
            $out = str_replace('{price}', '<span>' . $price . '</span>', $out);
    
            return $out;
        }

        public function slugify($string){
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
            $slug = strtolower($slug);
            return $slug;
        }
        
        public function hex2rgb($hex) {
            $hex = str_replace('#', '', $hex);
            list($red, $green, $blue) = sscanf($hex, "%02x%02x%02x");
            return $red . ',' . $green . ',' . $blue;
        }

        public function time_ago($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime(gmdate("Y-m-d H:i:s", $datetime));
            $diff = $now->diff($ago);
        
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        
            $string = array(
                'y' => __('year', 'coinpress'),
                'm' => __('month', 'coinpress'),
                'w' => __('week', 'coinpress'),
                'd' => __('day', 'coinpress'),
                'h' => __('hour', 'coinpress'),
                'i' => __('minute', 'coinpress'),
                's' => __('second', 'coinpress'),
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }
        
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ' . __('ago', 'coinpress') : __('just now', 'coinpress');
        }

        public function table_shortcode($id, $options, $title) {
                
            $colnames = [
                "no" => __("#", "coinpress"),
                "rank" => __("#", "coinpress"),
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
                "actions" => '<i class="fas fa-ellipsis-h"></i>',
            ];
        
            $output = '<div class="coinmc-table cdt-table coingrid cryptoboxes '. $options['table_style'] . '" id="coinmc-' . $id . '" data-realtime="'. (in_array('realtime', $options['settings']) ? "on" : "off") .'">';
        
            if ($title !== "") {
                $output .= '<div class="title-bar">' . $title . '</div>';
            }
        
            if ($options['table_type'] == 'advanced') {

                $output .= '<div class="cdt-fixedHeader"></div>';

                $output .= '<div class="cdt-table-tools">';
                $output .= '<div class="cmc-row">';
                $output .= '<div class="cmc-lg-6 cmc-md-8 cmc-sm-8 cmc-xs-12">';
                $output .= '<div class="cmc-row">';
                $output .= '<div class="cmc-md-7 cmc-sm-7 cmc-xs-12">';
                $output .= '<div class="coinmc-input-group">';
                $output .= '<i class="coinmc-input-addon fas fa-search"></i>';
                $output .= '<input type="text" class="coinmc-control coinmc-search" placeholder="' . __('Search..', 'coinpress') . '">';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="cmc-md-3 cmc-sm-3 cmc-xs-7">';
                $output .= '<div class="coinmc-dropdown coinmc-dropdown-select" data-position="bottom-start" data-theme="'. $options['table_style'] .'">';
                $output .= '<div class="coinmc-input-group coinmc-input-group-right">';
                $output .= '<i class="coinmc-input-addon fas fa-angle-down"></i>';
                $output .= '<input type="hidden" class="coinmc-currency coinmc-dropdown__input" value="'. $options['currency'].'" />';

                $currencies = array_column($this->config['currency_format'], null, 'iso');

                $output .= '<div class="coinmc-control coinmc-button"><i>'. $currencies[$options['currency']]['symbol'] .'</i> '. $options['currency'] .'</div>';
                $output .= '</div>';
                $output .= '<ul class="cryptoboxes coinpage coinmc-dropdown__list coinmc-dropdown-overflow">';
            
                foreach($this->config['currency_format'] as $format) {
                    $output .= '<li class="coinmc-dropdown__item"><a href="javascript:void(0);" data-action="currency" data-value="'.$format['iso'].'"><i>'.$format['symbol'].'</i> '.$format['iso'].'</a></li>';
                }

                $watchlistCoins = empty(get_user_meta(get_current_user_id(), 'cmc_watchlist', true)) ? [] : array_filter(get_user_meta(get_current_user_id(), 'cmc_watchlist', true));
                $watchlist_state = apply_filters('watchlist_user_control', true);
                $count = (!empty($watchlistCoins) && $watchlist_state) ? count($watchlistCoins) : 0;

                $output .= '</ul>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="cmc-md-2 cmc-sm-2 cmc-xs-5">';
                $output .= '<div class="coinmc-control coinmc-button coinmc-wlist-btn tippy-tooltip" data-tippy-content="' . __('Watchlist', 'coinpress') . '"><div class="far fa-star"></div> '.$count.'</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="cmc-lg-6 cmc-md-4 cmc-sm-4 cmc-xs-12 end-sm end-md end-lg coinmc-pagination">';
                $output .= '<div class="cmc-row end-sm end-md">';
                $output .= '<div class="cmc-lg-4 cmc-md cmc-sm cmc-xs coinmc-previous-btn">';
                $output .= '<div class="coinmc-control coinmc-button"><i class="fas fa-long-arrow-alt-left"></i> ' . __('Previous', 'coinpress') . ' ' .$options['table_length'].'</div>';
                $output .= '</div>';
                $output .= '<div class="cmc-lg-4 cmc-md cmc-sm cmc-xs coinmc-next-btn">';
                $output .= '<div class="coinmc-control coinmc-button">' . __('Next', 'coinpress') . ' ' .$options['table_length'].' <i class="fas fa-long-arrow-alt-right"></i></div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

            }

            $config = array(
                'type' => $options['table_type'],
                'page' => $options['page'],
                'length' => $options['table_length'],
                'theme' => $options['table_style'],
                'responsive' => ($options['table_restype'] === 'collapse') ? true : false,
                'total' => (sizeof($options['coins']) > 0) ? sizeof($options['coins']) : $options['numcoins'],
                'chartcolor' => $this->hex2rgb($options['chart_color']),
                'realtime' => (in_array('realtime', $options['settings'])) ? true : false,
                'fixedcol' => (in_array('fixedcol', $options['settings'])) ? true : false,
                'fixedhead' => (in_array('fixedhead', $options['settings'])) ? true : false,
                'watchlist' => $options['watchlist']
            );

            $output .= '<table class="coinmc-datatable dataTable display nowrap table-'. $options['table_restype'] .'" style="width: 100%" data-config="'. htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8') .'">';
            $output .= '<thead><tr>';
        
            foreach ($options['table_columns'] as $column) {
                $align = ($column == 'rank' || $column == 'name') ? ' text-left' : '';
                $output .= '<th class="col-' . $column . $align . '" data-col=' . $column . '>'. $colnames[$column] .'</th>';
            }
            $output .= '</tr></thead>';
            $output .= '<tbody>';
        
            $count = 0;
            $shortprice = ($options['price_format'] == 1) ? true : false;
        
            $output .= '</tbody>';
            $output .= '</table>';

            if ($options['table_type'] == 'advanced') {

                $output .= '<div class="coinmc-dt-footer dataTables-footer">';
                $output .= '<div class="cmc-row middle-md middle-sm between-md between-sm">';
                $output .= '<div class="cmc-lg-6 cmc-md-8 cmc-sm-12 cmc-xs-12 start-md center-sm center-xs">';
                $output .= '<div class="cmc-row">';
                $output .= '<div class="cmc-md">';
                $output .= '<span class="dataTables_info"></span>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="cmc-lg-6 cmc-md-4 cmc-sm-12 cmc-xs-12 end-md end-sm coinmc-pagination">';
                $output .= '<div class="cmc-row end-md end-sm">';
                $output .= '<div class="cmc-lg-4 cmc-md cmc-sm coinmc-previous-btn">';
                $output .= '<div class="coinmc-control coinmc-button"><i class="fas fa-long-arrow-alt-left"></i>' . __('Previous', 'coinpress') . ' ' .$options['table_length'].'</i></div>';
                $output .= '</div>';
                $output .= '<div class="cmc-lg-4 cmc-md cmc-sm coinmc-next-btn">';
                $output .= '<div class="coinmc-control coinmc-button">'. __('Next', 'coinpress') . ' ' .$options['table_length'].' <i class="fas fa-long-arrow-alt-right"></i></div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

            }

            $output .= '</div>';
  
            return $output;
        }

        public function global_shortcode($id, $options) {

            $css = '';

            if ($options['global_color'] == 'custom') {
                $css = '#coinmc-'.$id.' .coinmc-ticker { color: '.$options['text_color'].'; background-color: '.$options['background_color'].'; }';
            }

            wp_add_inline_style("coinmc-custom", $css);

            $output = '<div id="coinmc-' . $id . '" class="cryptoboxes">';
            $output .= '<div class="coinmc-ticker coingrid coinmc-'. $options['global_position'] .' cc-'. $options['global_color'] .'-color '. (in_array('rounded', $options['settings']) ? 'cc-ticker-round' : '') .'">';
            $output .= '<div class="coinmc-ticker-arrow"><i class="fas fa-angle-down"></i></div>';
            $output .= '<div class="cmc-row around-md">';

            if(isset($options['data']['active_cryptocurrencies'])){
                $output .= '<div class="cmc-lg cmc-md-4 cmc-sm-6 cmc-xs-12 coinmc-stat"><div>' . __('Cryptocurrencies', 'coinpress') . ': <span>'. $this->number_format($options['data']['active_cryptocurrencies'], $options['currency'], false, 0) .'</span></div></div>';
            }

            if(isset($options['data']['markets'])){
                $output .= '<div class="cmc-lg cmc-md-4 cmc-sm-6 cmc-xs-12 coinmc-stat"><div>' . __('Markets', 'coinpress') . ': <span>'. $this->number_format($options['data']['markets'], $options['currency'], false, 0) .'</span></div></div>';
            }

            if(isset($options['data']['marketcap'])){
                $output .= '<div class="cmc-lg cmc-md-4 cmc-sm-6 cmc-xs-12 coinmc-stat"><div>' . __('Marketcap', 'coinpress') . ': <span>'. $this->price_format($options['data']['marketcap'], $options['exrate'], $options['currency'], ($options['price_format'] == 1) ? true : false, 0) .'</span>';
                if(isset($options['data']['marketcap_change'])){
                    $output .= '<span class="global-perct '.($options['data']['marketcap_change'] > 0 ? 'uptrend' : 'downtrend').'">('.$this->number_format($options['data']['marketcap_change'], $options['currency'], false, 2).'%)</span>';
                }
            }

            $output .= '</div></div>';
            
            if(isset($options['data']['24hvol'])){
                $output .= '<div class="cmc-lg cmc-md-4 wcmc-sm-6 cmc-xs-12 coinmc-stat"><div>' . __('24h Vol', 'coinpress') . ': <span>'. $this->price_format($options['data']['24hvol'], $options['exrate'], $options['currency'], ($options['price_format'] == 1) ? true : false, 0) .'</span>';
                if(isset($options['data']['24hvol_change'])){
                    $output .= '<span class="global-perct '.($options['data']['24hvol_change'] > 0 ? 'uptrend' : 'downtrend').'">('.$this->number_format($options['data']['24hvol_change'], $options['currency'], false, 2).'%)</span>';
                }
                $output .= '</div></div>';
            }

            if(isset($options['data']['btcdominance'])){
                $output .= '<div class="cmc-lg cmc-md-4 cmc-sm-6 cmc-xs-12 coinmc-stat"><div>' . __('BTC Dominance', 'coinpress') . ': <span>'. $this->number_format($options['data']['btcdominance'], $options['currency'], false, 2) .'%</span></div></div>';
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_logoname($coin) {
            $output = '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<div class="coin-name"><img src="'. str_replace('large', 'small', $coin->img) .'" width="48" alt="">';
            $output .= $coin->name;
            $output .= '<div class="coin-symbol">'. $coin->symbol .'</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_prices($coin, $options) {
            $output = '<div class="cmc-row between-md">';
            $output .= '<div class="cmc-lg-3 cmc-md-12 cmc-stats">';
            $output .= '<div class="coin-price" data-price="'. $coin->price_usd .'" data-live-price="'. $this->slugify($coin->name) .'" data-rate="'. $options['exrate'] .'" data-currency="'. $this->config['currency'] .'">'. $this->price_format($coin->price_usd, $options['exrate'], $this->config['currency']) . '</div>';
            $output .= '<div class="coin-price-btc">'. $coin->price_btc .' BTC</div>';
            $output .= '</div>';
            $output .= '<div class="cmc-lg-9 cmc-md-12">';
            $output .= '<div class="cmc-row">';
            $output .= '<div class="cmc-md-3 cmc-sm-6 cmc-xs-12 cmc-stats"><div class="stat-label">' . __('Marketcap', 'coinpress') . '</div><div class="stat-value">' . $this->price_format($coin->market_cap_usd, $options['exrate'], $this->config['currency'], false, 0) .'</div></div>';
            $output .= '<div class="cmc-md-3 cmc-sm-6 cmc-xs-12 cmc-stats"><div class="stat-label">'. __('Volume (24h)', 'coinpress') . '</div><div class="stat-value">' . $this->price_format($coin->volume_usd_24h, $options['exrate'], $this->config['currency'], false, 0) .'</div></div>';
            $output .= '<div class="cmc-md-3 cmc-sm-6 cmc-xs-12 cmc-stats"><div class="stat-label">'. __('Circulating Supply', 'coinpress') . '</div><div class="stat-value">'. $this->number_format($coin->available_supply, $this->config['currency'], false, 0) . ' ' . $coin->symbol . '</div></div>';
            $output .= '<div class="cmc-md-3 cmc-sm-6 cmc-xs-12 cmc-stats"><div class="stat-label">'. __('Total Supply', 'coinpress') . '</div><div class="stat-value">'. ($coin->total_supply == '0' ? __('∞', 'coinpress') : $this->number_format($coin->total_supply, $this->config['currency'], false, 0) . ' ' . $coin->symbol) . '</div></div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function watchlist_button($coin) {
            
            $output = '<div class="coinmc-cta">';
            $output .= '<div class="cmc-row">';
            $output .= '<div class="cmc-xs-12 cmc-sm-12 cmc-md">';
            $output .= '<a href="javascript:void(0);" data-action="watchlist" data-value="'. $coin->slug .'" class="coinmc-watchlist coinmc-button coinmc-button-white"><i class="far fa-star"></i> ' . __('Add to Watchlist', 'coinpress') . '</a>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_buttons($coin) {
            $output = '<div class="coinmc-cta">';
            $output .= '<div class="cmc-row">';
            if ($this->config['changelly'] !== '' && strpos($this->config['changelly'], 'changelly.com') !== false) {
                $output .= '<div class="cmc-xs-12 cmc-sm-6 cmc-md">';
                $output .= '<a href="https://changelly.com/exchange/USD/'. $coin->symbol .'/1?ref_id='. (($this->config['changelly'] === '') ? '' : explode('?ref_id=', $this->config['changelly'])[1]) .'" target="_blank" rel="nofollow" class="coinmc-button coinmc-button-success"><i class="fas fa-shopping-cart"></i> ' . __('Buy', 'coinpress') . ' '. $coin->name .'</a>';
                $output .= '</div>';
                $output .= '<div class="cmc-xs-12 cmc-sm-6 cmc-md">';
                $output .= '<a href="https://changelly.com/exchange/'. $coin->symbol .'/BTC/1?ref_id='. (($this->config['changelly'] === '') ? '' : explode('?ref_id=', $this->config['changelly'])[1]) .'" target="_blank" rel="nofollow" class="coinmc-button coinmc-button-danger"><i class="fas fa-cart-arrow-down"></i> ' . __('Sell', 'coinpress') . ' '. $coin->name .'</a>';
                $output .= '</div>';
            } else if ($this->config['changelly'] !== '') {
                $trade_url = str_replace(array('{symbol}', '{slug}'), array($coin->symbol, $coin->slug), $this->config['changelly']);
                $output .= '<div class="cmc-xs-12 cmc-sm-6 cmc-md">';
                $output .= '<a href="' . $trade_url . '" target="_blank" rel="nofollow" class="coinmc-button coinmc-button-success"><i class="fas fa-shopping-cart"></i> ' . __('Buy', 'coinpress') . ' '. $coin->name .'</a>';
                $output .= '</div>';
                $output .= '<div class="cmc-xs-12 cmc-sm-6 cmc-md">';
                $output .= '<a href="' . $trade_url . '" target="_blank" rel="nofollow" class="coinmc-button coinmc-button-danger"><i class="fas fa-cart-arrow-down"></i> ' . __('Sell', 'coinpress') . ' '. $coin->name .'</a>';
                $output .= '</div>';
            }
            // $output .= '<div class="cmc-xs-12 cmc-sm-6 cmc-md">';
            // $output .= '<a href="javascript:void(0);" data-action="watchlist" data-value="'. $coin->slug .'" class="coinmc-watchlist coinmc-button coinmc-button-white"><i class="far fa-star"></i> ' . __('Add to Watchlist', 'coinpress') . '</a>';
            // $output .= '</div>';
            // $output .= '</div>';
            // $output .= '</div>';
            return $output;
        }

        public function single_desc($coin, $meta) {
            $output = '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<div class="coin-description">';
            if ($meta && $meta->description !== '') {
                $output .= '<p>'. do_shortcode(nl2br(stripslashes($meta->description))) .'</p>';
            } else {
                $output .= '<p>' . do_shortcode($this->config['description']) . '</p>';
            }
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_links($coin, $meta) {
            $output = '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<ul class="coinmc-links">';

            if ($meta && $meta->website !== '') {
                $output .= '<li><a href="'. $meta->website . '" target="_blank"><i class="fas fa-link"></i> '. __('Website', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->explorer !== '') {
                $output .= '<li><a href="'. $meta->explorer . '" target="_blank"><i class="fas fa-search"></i> '. __('Explorer', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->facebook !== '') {
                $output .= '<li><a href="'. $meta->facebook . '" target="_blank"><i class="fab fa-facebook"></i> '. __('Facebook', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->twitter !== '') {
                $output .= '<li><a href="'. $meta->twitter . '" target="_blank"><i class="fab fa-twitter"></i> '. __('Twitter', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->reddit !== '') {
                $output .= '<li><a href="'. $meta->reddit . '" target="_blank"><i class="fab fa-reddit"></i> '. __('Reddit', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->youtube !== '') {
                $output .= '<li><a href="'. $meta->youtube . '" target="_blank"><i class="fab fa-youtube"></i> '. __('Youtube', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->source !== '') {
                $output .= '<li><a href="'. $meta->source . '" target="_blank"><i class="fas fa-code"></i> '. __('Source Code', 'coinpress') . '</a></li>';
            }
            if ($meta && $meta->whitepaper !== '') {
                $output .= '<li><a href="'. $meta->whitepaper . '" target="_blank"><i class="far fa-newspaper"></i> '. __('White Paper', 'coinpress') . '</a></li>';
            }

            $output .= '</ul>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_calculator($coin, $coins, $options) {
            $output = '<div class="coinmc-calculator">';
            $output .= '<div class="cmc-row middle-md center-md">';
            $output .= '<div class="cmc-md-4 cmc-sm-5 cmc-xs-12">';
            $output .= '<div class="coinmc-form-control">';
            $output .= '<div class="coinmc-dropdown coinmc-dropdown-select" data-position="bottom-start" data-theme="light">';
            $output .= '<div class="coinmc-input-group coinmc-input-group-right">';
            $output .= '<i class="coinmc-input-addon fas fa-angle-down"></i>';
            $output .= '<input name="currency" class="coinmc-dropdown__input" type="hidden" value="'. $coin->price_usd .'">';
            $output .= '<div class="coinmc-control coinmc-button">'. $coin->symbol .'</div>';
            $output .= '</div>';
            $output .= '<ul class="cryptoboxes coinpage coinmc-calculator-list coinmc-dropdown__list coinmc-dropdown-overflow">';

            foreach($coins as $thiscoin) {
                $output .= '<li class="coinmc-dropdown__item"><a href="javascript:void(0);" data-action="currency" data-label="'. $thiscoin->symbol .'" data-value="'. $thiscoin->price_usd .'">'. $thiscoin->symbol .'</a></li>';
            }

            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<input type="text" class="coinmc-control coinmc-field" value="1">';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="cmc-md-2 cmc-sm-2 cmc-xs-12 center-md center-sm hidden-xs">';
            $output .= '<div class="coinmc-form-control coinmc-form-swap"><i class="fas fa-exchange-alt"></i></div>';
            $output .= '</div>';

            $output .= '<div class="cmc-md-4 cmc-sm-5 cmc-xs-12">';
            $output .= '<div class="coinmc-form-control">';
            $output .= '<div class="coinmc-dropdown coinmc-dropdown-select" data-position="bottom-start" data-theme="light">';
            $output .= '<div class="coinmc-input-group coinmc-input-group-right">';
            $output .= '<i class="coinmc-input-addon fas fa-angle-down"></i>';
            $output .= '<input name="currency" class="coinmc-dropdown__input" type="hidden" value="' . $options['exrate'] . '">';
            $output .= '<div class="coinmc-control coinmc-button">'. $this->config['currency'] .'</div>';
            $output .= '</div>';
            $output .= '<ul class="cryptoboxes coinpage coinmc-calculator-list coinmc-dropdown__list coinmc-dropdown-overflow">';

            foreach($options['currencies'] as $key => $value) {
                $output .= '<li class="coinmc-dropdown__item"><a href="javascript:void(0);" data-action="currency" data-label="'. $key .'" data-value="'. $value .'">'. $key .'</a></li>';
            }

            $output .= '</ul>';
            $output .= '</div>';
            $cal_price =  strip_tags($this->price_format($coin->price_usd, $options['exrate'], $this->config['currency']));
            $output .= '<input type="text" class="coinmc-control coinmc-field" value="'. $cal_price .'">';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        public function single_tabs($atts, $content) {

            $this->tabscontent = '';

            $output = '<div class="cryptoboxes">';
            $output .= '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<div class="coinmc-tabs">';
            $output .= '<ul class="coinmc-tabs-list">'. do_shortcode($content) .'</ul>';
            $output .= '<div class="coinmc-tabs-content">'. $this->tabscontent .'</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;

        }

        public function single_tab($atts, $content) {

            $atts = shortcode_atts(array(
                'icon' => '',
                'title' => 'Tab',
            ), $atts);

            $this->tabscontent .= '<div class="coinmc-tab-content">'. do_shortcode($content) .'</div>';
            $output = '<li class="coinmc-tab"><i class="'. $atts['icon'] .'"></i><span>'. $atts['title'] .'</span></li>';
            return $output;
        }

        public function single_chart($coin, $options) {

            $config = array(
                'type' => 'chart',
                'coin' => $coin->slug,
                'symbol' => $coin->symbol,
                'currency' => $this->config['currency'],
                'period' => 'month',
                'theme' => 'light',
                'smooth' => true,
                'areaColor' => 'rgb(' . $this->hex2rgb($this->config['theme_color']) . ', 0.8)',                
                'font' => $this->config['font'],
                'rate' => $options['exrate']
            );
            
            $output = '<div class="coinmc-chart coinmc-trigger">';
            $output .= '<div class="cmc-row middle-md between-md">';
            $output .= '<div class="cmc-md-7 cmc-sm-12 cmc-xs-12">';
            $output .= '<ul class="coinmc-filter coinmc-chart-period">';
            $output .= '<li><div class="coinmc-filter-label">' . __('Zoom', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-period="hour">' . __('Hour', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-period="day">' . __('Day', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-period="week">' . __('Week', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button active" data-period="month">' . __('Month', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-period="year">' . __('Year', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-period="all">' . __('All Time', 'coinpress') . '</div></li>';
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<div class="cmc-md-5 cmc-sm-12 cmc-xs-12 end-md start-sm start-xs">';
            $output .= '<ul class="coinmc-filter coinmc-chart-type">';
            $output .= '<li><div class="coinmc-filter-label">' . __('Type', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button active" data-type="chart"><i class="fas fa-chart-line"></i> ' . __('Line Chart', 'coinpress') . '</div></li>';
            $output .= '<li><div class="coinmc-filter-button" data-type="candlestick"><i class="fas fa-sliders-h"></i> ' . __('Candlestick', 'coinpress') . '</div></li>';
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<div class="chart-wrapper" data-config="'. htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8') .'"></div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;

        }

        public function single_historical($coin, $options) {

            $output = '<div class="coinmc-history coinmc-trigger">';
            $output .= '<div class="cmc-row between-md middle-md middle-sm">';
            $output .= '<div class="cmc-md-6 cmc-sm-6 cmc-xs-12">';
            $output .= '<small>* ' . __('Currency in', 'coinpress') . ' '. $this->config['currency'] . '</small>';
            $output .= '</div>';
            $output .= '<div class="cmc-md-4 cmc-sm-6 cmc-xs-12">';
            $output .= '<div class="coinmc-form-control">';
            $output .= '<div class="coinmc-input-group">';
            $output .= '<i class="coinmc-input-addon far fa-calendar-alt"></i>';
            $output .= '<input type="text" class="coinmc-control dateselector" value="2018-10-18 to 2018-10-19">';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="cmc-row">';
            $output .= '<div class="cdt-table light" data-theme="light">';
            $output .= '<div class="title-bar">'. __('Historical Price for', 'coinpress') . ' '. $coin->name .'</div>';
            $output .= '<table class="coinmc-datatable dataTable display nowrap" style="width: 100%" data-coin="'. $coin->symbol .'" data-currency="'. $this->config['currency'] .'">';
            $output .= '<thead>';
            $output .= '<th class="col-date" data-col="date">'. __('Date', 'coinpress') . '</th>';
            $output .= '<th class="col-open" data-col="open">'. __('Open', 'coinpress') . '</th>';
            $output .= '<th class="col-close" data-col="close">'. __('Close', 'coinpress') . '</th>';
            $output .= '<th class="col-high" data-col="high">'. __('High', 'coinpress') . '</th>';
            $output .= '<th class="col-low" data-col="low">'. __('Low', 'coinpress') . '</th>';
            $output .= '<th class="col-volume" data-col="volume">'. __('Volume', 'coinpress') . '</th>';
            $output .= '</thead>';
            $output .= '<tbody>';
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        public function single_markets($coin, $options) {
            
            $output = '<div class="cmc-row">';
            $output .= '<div class="cmc-md-12">';
            $output .= '<div class="coinmc-trigger coinmc-markets cdt-table light">';
            $output .= '<div class="title-bar">'. $coin->name .' '. __('Markets', 'coinpress') . '</div>';
            $output .= '<table class="coinmc-datatable dataTable display nowrap" style="width: 100%" data-coin="'. $coin->symbol .'" data-currency="'. $this->config['currency'] .'">';
            $output .= '<thead>';
            $output .= '<th class="col-rank" data-col="rank">#</th>';
            $output .= '<th class="col-source" data-col="source">'. __('Source', 'coinpress') . '</th>';
            $output .= '<th class="col-pair" data-col="pair">'. __('Pair', 'coinpress') . '</th>';
            $output .= '<th class="col-volume" data-col="volume">'. __('Volume', 'coinpress') . '</th>';
            $output .= '<th class="col-price" data-col="price">'. __('Price', 'coinpress') . '</th>';
            $output .= '<th class="col-change" data-col="change">'. __('Change', 'coinpress') . '</th>';
            $output .= '<th class="col-update" data-col="update">'. __('Updated', 'coinpress') . '</th>';
            $output .= '</thead>';
            $output .= '<tbody>';
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        public function single_social($coin, $meta) {

            $output = '<div class="coinmc-social">';
            $output .= '<div class="cmc-row">';

            if ($meta && $meta->twitter !== '') {
                $handle = explode('/', $meta->twitter);
                $output .= '<div class="cmc-md cmc-sm-12 cmc-xs-12">';
                $output .= '<ul class="coinmc-twitter coinmc-trigger coinmc-nice-scroll" data-handle="'. end($handle) .'">';
                $output .= '</ul>';
                $output .= '</div>';
            }

            if ($meta && $meta->reddit !== '') {
                $subreddit = explode('/', $meta->reddit);
                $output .= '<div class="cmc-md cmc-sm-12 cmc-xs-12">';
                $output .= '<ul class="coinmc-reddit coinmc-trigger coinmc-nice-scroll" data-sub="'. $meta->reddit .'">';
                $output .= '<li class="coinmc-r-heading">';
                $output .= '<i class="fab fa-reddit"></i>';
                $output .= '<div class="coinmc-r-sub">r/'. end($subreddit) .'</div>';
                $output .= '</li>';
                $output .= '</ul>';
                $output .= '</div>';
            }

            $output .= '</div>';
            $output .= '</div>';
            return $output;

        }

        public function reddit_content($data) {
            $output = "";

            foreach ($data->data->children as $thread) {
                if ($thread->data->stickied === false) {
                    $output .= '<li>';
                    $output .= '<div class="coinmc-r-thread">';
                    $output .= '<div class="coinmc-r-media">';
                    $output .= '<div class="coinmc-r-img"' . (($thread->data->thumbnail !== 'self') ? ' style="background-image: url('. $thread->data->thumbnail .');"' : '') . '></div>';
                    $output .= '</div>';
                    $output .= '<div class="coinmc-r-content">';
                    $output .= '<a href="https://reddit.com'. $thread->data->permalink .'" target="_blank" class="coinmc-r-title">'. $thread->data->title .'</a>';
                    $output .= '<div class="coinmc-r-author">'. $thread->data->author .'</div>';
                    $output .= '<div class="coinmc-r-stat"><i class="fas fa-arrow-up"></i> '. $thread->data->ups .'<i class="far fa-comment"></i> '. $thread->data->num_comments .' '. __('comments', 'coinpress') . '<i class="far fa-clock"></i> '. $this->time_ago($thread->data->created) .'</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</li>';
                }
            }
            return $output;
        }

        public function single_comments($coin) {
            $pages = new Pages($this->config);
            $output = '<div class="fb-comments" data-href="'. site_url($pages->get_link($coin->slug, $this->config)) .'" data-width="100%" data-numposts="10"></div>';

            $output .= '<div id="fb-root"></div>';
            $output .= '<script>(function(d, s, id) {';
            $output .= 'var js, fjs = d.getElementsByTagName(s)[0];';
            $output .= 'if (d.getElementById(id)) return;';
            $output .= 'js = d.createElement(s); js.id = id;';
            $output .= 'js.src = "https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2";';
            $output .= 'fjs.parentNode.insertBefore(js, fjs);';
            $output .= '}(document, "script", "facebook-jssdk"));</script>';

            return $output;
        }

        public function single_news($coin) {

            $feeds = explode("\n", $this->config['news_feeds']);

            $output = '<div class="cmc-row">';
            $output .= '<div class="cmc-md">';
            $output .= '<ul class="coinmc-news coinmc-nice-scroll">';
            
            foreach($feeds as $index => $feed){
                $rss = fetch_feed($feed);
                if (!is_wp_error($rss)) {
                    $maxitems = $rss->get_item_quantity(5);
                    $items = $rss->get_items(0, $maxitems);
        
                    foreach ($items as $item) {
                        $output .= '<li>';
                        $output .= '<div class="coinmc-n-single">';
                        $output .= '<a href="'. esc_url($item->get_permalink()) .'" target="_blank" class="coinmc-n-media">';
        
                        $output .= '<div class="coinmc-n-img"';
        
                        $media = $item->get_enclosure()->get_link();
        
                        if (empty($media)) {
                            preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $item->get_description(), $matches);
        
                            if ($matches) {
                                $media .= $matches[1];
                            }
                        }
        
                        if (!empty($media)) {
                            $output .= ' style="background-image: url('. $media .');"';
                        }
        
                        $output .= '></div>';
        
                        $output .= '</a>';
                        $output .= '<div class="coinmc-n-content">';
                        $output .= '<a href="'. esc_url($item->get_permalink()) .'" target="_blank" class="coinmc-n-title">'. esc_html($item->get_title()) .'</a>';
                        $output .= '<div class="coinmc-n-stat">'. esc_html($item->get_feed()->get_title()) .' - '. $this->time_ago(strtotime($item->get_date())) .'</div>';
        
                        $description = $item->get_description();
                        $description = wp_kses(trim($description), array());
                        $description = strip_tags(apply_filters('the_excerpt', $description));
                        $description = wp_trim_words($description, 25);
                        $description = trim(preg_replace('!\s+!', ' ', $description));	
        
                        $output .= '<div class="coinmc-n-text">'. $description .'</div>';
        
                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</li>';
                    }
                }
            }
            
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
        
    }

}