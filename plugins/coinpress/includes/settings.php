<div class="wrap coinmc-settings coingrid">
    <h2><?php _e('Settings', 'coinpress'); ?></h2>
    <?php if (isset($_GET['success'])) { ?>
        <div class="updated notice">
            <p><b><?php _e('Settings saved.', 'coinpress'); ?></b></p>
        </div>
    <?php } ?>
    <div class="crypto-edit">
        <div class="vue-component">
            <coinmc-settings :options='<?php echo htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8'); ?>'></coinmc-settings>
        </div>
    </div>
</div>

<template id="coinmc-settings-template">

    <form action="<?php echo admin_url('admin-post.php'); ?>" id="coinmc-settings-form" method="POST">

        <input type="hidden" name="action" value="coinmc_save_settings">

        <div class="wrapper">

            <div class="coinmc-sections">
                    
                <div class="section-left">

                    <div class="form-control">
                        <ul class="page-menu">
                            <?php if ($config['license'] == 'regular' || $config['license'] == 'extended') { ?>
                            <li data-page="general" v-bind:class="{ 'active' : (menu === 'general') }" v-on:click="toggleMenu('general')"><?php _e('General', 'coinpress'); ?></li>
                            <li data-page="api" v-bind:class="{ 'active' : (menu === 'api') }" v-on:click="toggleMenu('api')"><?php _e('API', 'coinpress'); ?></li>
                            <li data-page="coindetails" v-bind:class="{ 'active' : (menu === 'coindetails') }" v-on:click="toggleMenu('coindetails')"><?php _e('Coin Details', 'coinpress'); ?></li>
                            <li data-page="shortcodes" v-bind:class="{ 'active' : (menu === 'shortcodes') }" v-on:click="toggleMenu('shortcodes')"><?php _e('Shortcodes', 'coinpress'); ?></li>
                            <li data-page="currency" v-bind:class="{ 'active' : (menu === 'currency') }" v-on:click="toggleMenu('currency')"><?php _e('Currency Format', 'coinpress'); ?></li>
                            <?php } ?>
                            <li data-page="license" v-bind:class="{ 'active' : (menu === 'license') }" v-on:click="toggleMenu('license')"><?php _e('License', 'coinpress'); ?></li>
                        </ul>
                        <a href="https://docs.blocksera.com/coinpress" target="_blank" class="btn-link">                            
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documentation
                        </a>
                    </div>

                    <div class="form-control">
                        <button class="coinmc-button coinmc-button-block coinmc-button-lg coinmc-button-primary"><?php _e('Save Details', 'coinpress'); ?></button>
                    </div>

                </div>

                <div class="section-right">

                        <div id="page-currency" class="page-content" v-show="menu==='currency'">
                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <h3>Default Format</h3>
                                </div>
                                <div class="crypto-cols">
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <th>Currency</th>
                                                <th>Symbol</th>
                                                <th>Position</th>
                                                <th>Thousands Sep.</th>
                                                <th>Decimal Sep.</th>
                                                <th>Decimals</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="default_currency_format[iso]" id="" class="selectize-select" v-model="opts.default_currency_format.iso">
                                                        <option value="AED">United Arab Emirates dirham (&#x62f;.&#x625;)</option>
                                                        <option value="AFN">Afghan afghani (&#x60b;)</option>
                                                        <option value="ALL">Albanian lek (L)</option>
                                                        <option value="AMD">Armenian dram (AMD)</option>
                                                        <option value="ANG">Netherlands Antillean guilder (&fnof;)</option>
                                                        <option value="AOA">Angolan kwanza (Kz)</option>
                                                        <option value="ARS">Argentine peso (&#036;)</option>
                                                        <option value="AUD">Australian dollar (&#036;)</option>
                                                        <option value="AWG">Aruban florin (Afl.)</option>
                                                        <option value="AZN">Azerbaijani manat (AZN)</option>
                                                        <option value="BAM">Bosnia and Herzegovina convertible mark (KM)</option>
                                                        <option value="BBD">Barbadian dollar (&#036;)</option>
                                                        <option value="BDT">Bangladeshi taka (&#2547;&nbsp;)</option>
                                                        <option value="BGN">Bulgarian lev (&#1083;&#1074;.)</option>
                                                        <option value="BHD">Bahraini dinar (.&#x62f;.&#x628;)</option>
                                                        <option value="BIF">Burundian franc (Fr)</option>
                                                        <option value="BMD">Bermudian dollar (&#036;)</option>
                                                        <option value="BND">Brunei dollar (&#036;)</option>
                                                        <option value="BOB">Bolivian boliviano (Bs.)</option>
                                                        <option value="BRL">Brazilian real (&#082;&#036;)</option>
                                                        <option value="BSD">Bahamian dollar (&#036;)</option>
                                                        <option value="BTC">Bitcoin (&#3647;)</option>
                                                        <option value="BTN">Bhutanese ngultrum (Nu.)</option>
                                                        <option value="BWP">Botswana pula (P)</option>
                                                        <option value="BYR">Belarusian ruble (old) (Br)</option>
                                                        <option value="BYN">Belarusian ruble (Br)</option>
                                                        <option value="BZD">Belize dollar (&#036;)</option>
                                                        <option value="CAD">Canadian dollar (&#036;)</option>
                                                        <option value="CDF">Congolese franc (Fr)</option>
                                                        <option value="CHF">Swiss franc (&#067;&#072;&#070;)</option>
                                                        <option value="CLP">Chilean peso (&#036;)</option>
                                                        <option value="CNY">Chinese yuan (&yen;)</option>
                                                        <option value="COP">Colombian peso (&#036;)</option>
                                                        <option value="CRC">Costa Rican col&oacute;n (&#x20a1;)</option>
                                                        <option value="CUC">Cuban convertible peso (&#036;)</option>
                                                        <option value="CUP">Cuban peso (&#036;)</option>
                                                        <option value="CVE">Cape Verdean escudo (&#036;)</option>
                                                        <option value="CZK">Czech koruna (&#075;&#269;)</option>
                                                        <option value="DJF">Djiboutian franc (Fr)</option>
                                                        <option value="DKK">Danish krone (DKK)</option>
                                                        <option value="DOP">Dominican peso (RD&#036;)</option>
                                                        <option value="DZD">Algerian dinar (&#x62f;.&#x62c;)</option>
                                                        <option value="EGP">Egyptian pound (EGP)</option>
                                                        <option value="ERN">Eritrean nakfa (Nfk)</option>
                                                        <option value="ETB">Ethiopian birr (Br)</option>
                                                        <option value="EUR">Euro (&euro;)</option>
                                                        <option value="FJD">Fijian dollar (&#036;)</option>
                                                        <option value="FKP">Falkland Islands pound (&pound;)</option>
                                                        <option value="GBP">Pound sterling (&pound;)</option>
                                                        <option value="GEL">Georgian lari (&#x20be;)</option>
                                                        <option value="GGP">Guernsey pound (&pound;)</option>
                                                        <option value="GHS">Ghana cedi (&#x20b5;)</option>
                                                        <option value="GIP">Gibraltar pound (&pound;)</option>
                                                        <option value="GMD">Gambian dalasi (D)</option>
                                                        <option value="GNF">Guinean franc (Fr)</option>
                                                        <option value="GTQ">Guatemalan quetzal (Q)</option>
                                                        <option value="GYD">Guyanese dollar (&#036;)</option>
                                                        <option value="HKD">Hong Kong dollar (&#036;)</option>
                                                        <option value="HNL">Honduran lempira (L)</option>
                                                        <option value="HRK">Croatian kuna (kn)</option>
                                                        <option value="HTG">Haitian gourde (G)</option>
                                                        <option value="HUF">Hungarian forint (&#070;&#116;)</option>
                                                        <option value="IDR">Indonesian rupiah (Rp)</option>
                                                        <option value="ILS">Israeli new shekel (&#8362;)</option>
                                                        <option value="IMP">Manx pound (&pound;)</option>
                                                        <option value="INR">Indian rupee (&#8377;)</option>
                                                        <option value="IQD">Iraqi dinar (&#x639;.&#x62f;)</option>
                                                        <option value="IRR">Iranian rial (&#xfdfc;)</option>
                                                        <option value="IRT">Iranian toman (&#x62A;&#x648;&#x645;&#x627;&#x646;)</option>
                                                        <option value="ISK">Icelandic kr&oacute;na (kr.)</option>
                                                        <option value="JEP">Jersey pound (&pound;)</option>
                                                        <option value="JMD">Jamaican dollar (&#036;)</option>
                                                        <option value="JOD">Jordanian dinar (&#x62f;.&#x627;)</option>
                                                        <option value="JPY">Japanese yen (&yen;)</option>
                                                        <option value="KES">Kenyan shilling (KSh)</option>
                                                        <option value="KGS">Kyrgyzstani som (&#x441;&#x43e;&#x43c;)</option>
                                                        <option value="KHR">Cambodian riel (&#x17db;)</option>
                                                        <option value="KMF">Comorian franc (Fr)</option>
                                                        <option value="KPW">North Korean won (&#x20a9;)</option>
                                                        <option value="KRW">South Korean won (&#8361;)</option>
                                                        <option value="KWD">Kuwaiti dinar (&#x62f;.&#x643;)</option>
                                                        <option value="KYD">Cayman Islands dollar (&#036;)</option>
                                                        <option value="KZT">Kazakhstani tenge (KZT)</option>
                                                        <option value="LAK">Lao kip (&#8365;)</option>
                                                        <option value="LBP">Lebanese pound (&#x644;.&#x644;)</option>
                                                        <option value="LKR">Sri Lankan rupee (&#xdbb;&#xdd4;)</option>
                                                        <option value="LRD">Liberian dollar (&#036;)</option>
                                                        <option value="LSL">Lesotho loti (L)</option>
                                                        <option value="LYD">Libyan dinar (&#x644;.&#x62f;)</option>
                                                        <option value="MAD">Moroccan dirham (&#x62f;.&#x645;.)</option>
                                                        <option value="MDL">Moldovan leu (MDL)</option>
                                                        <option value="MGA">Malagasy ariary (Ar)</option>
                                                        <option value="MKD">Macedonian denar (&#x434;&#x435;&#x43d;)</option>
                                                        <option value="MMK">Burmese kyat (Ks)</option>
                                                        <option value="MNT">Mongolian t&ouml;gr&ouml;g (&#x20ae;)</option>
                                                        <option value="MOP">Macanese pataca (P)</option>
                                                        <option value="MRU">Mauritanian ouguiya (UM)</option>
                                                        <option value="MUR">Mauritian rupee (&#x20a8;)</option>
                                                        <option value="MVR">Maldivian rufiyaa (.&#x783;)</option>
                                                        <option value="MWK">Malawian kwacha (MK)</option>
                                                        <option value="MXN">Mexican peso (&#036;)</option>
                                                        <option value="MYR">Malaysian ringgit (&#082;&#077;)</option>
                                                        <option value="MZN">Mozambican metical (MT)</option>
                                                        <option value="NAD">Namibian dollar (&#036;)</option>
                                                        <option value="NGN">Nigerian naira (&#8358;)</option>
                                                        <option value="NIO">Nicaraguan c&oacute;rdoba (C&#036;)</option>
                                                        <option value="NOK">Norwegian krone (&#107;&#114;)</option>
                                                        <option value="NPR">Nepalese rupee (&#8360;)</option>
                                                        <option value="NZD">New Zealand dollar (&#036;)</option>
                                                        <option value="OMR">Omani rial (&#x631;.&#x639;.)</option>
                                                        <option value="PAB">Panamanian balboa (B/.)</option>
                                                        <option value="PEN">Sol (S/)</option>
                                                        <option value="PGK">Papua New Guinean kina (K)</option>
                                                        <option value="PHP">Philippine peso (&#8369;)</option>
                                                        <option value="PKR">Pakistani rupee (&#8360;)</option>
                                                        <option value="PLN">Polish z&#x142;oty (&#122;&#322;)</option>
                                                        <option value="PRB">Transnistrian ruble (&#x440;.)</option>
                                                        <option value="PYG">Paraguayan guaran&iacute; (&#8370;)</option>
                                                        <option value="QAR">Qatari riyal (&#x631;.&#x642;)</option>
                                                        <option value="RON">Romanian leu (lei)</option>
                                                        <option value="RSD">Serbian dinar (&#x434;&#x438;&#x43d;.)</option>
                                                        <option value="RUB">Russian ruble (&#8381;)</option>
                                                        <option value="RWF">Rwandan franc (Fr)</option>
                                                        <option value="SAR">Saudi riyal (&#x631;.&#x633;)</option>
                                                        <option value="SBD">Solomon Islands dollar (&#036;)</option>
                                                        <option value="SCR">Seychellois rupee (&#x20a8;)</option>
                                                        <option value="SDG">Sudanese pound (&#x62c;.&#x633;.)</option>
                                                        <option value="SEK">Swedish krona (&#107;&#114;)</option>
                                                        <option value="SGD">Singapore dollar (&#036;)</option>
                                                        <option value="SHP">Saint Helena pound (&pound;)</option>
                                                        <option value="SLL">Sierra Leonean leone (Le)</option>
                                                        <option value="SOS">Somali shilling (Sh)</option>
                                                        <option value="SRD">Surinamese dollar (&#036;)</option>
                                                        <option value="SSP">South Sudanese pound (&pound;)</option>
                                                        <option value="STN">S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra (Db)</option>
                                                        <option value="SYP">Syrian pound (&#x644;.&#x633;)</option>
                                                        <option value="SZL">Swazi lilangeni (L)</option>
                                                        <option value="THB">Thai baht (&#3647;)</option>
                                                        <option value="TJS">Tajikistani somoni (&#x405;&#x41c;)</option>
                                                        <option value="TMT">Turkmenistan manat (m)</option>
                                                        <option value="TND">Tunisian dinar (&#x62f;.&#x62a;)</option>
                                                        <option value="TOP">Tongan pa&#x2bb;anga (T&#036;)</option>
                                                        <option value="TRY">Turkish lira (&#8378;)</option>
                                                        <option value="TTD">Trinidad and Tobago dollar (&#036;)</option>
                                                        <option value="TWD">New Taiwan dollar (&#078;&#084;&#036;)</option>
                                                        <option value="TZS">Tanzanian shilling (Sh)</option>
                                                        <option value="UAH">Ukrainian hryvnia (&#8372;)</option>
                                                        <option value="UGX">Ugandan shilling (UGX)</option>
                                                        <option value="USD">United States (US) dollar (&#036;)</option>
                                                        <option value="UYU">Uruguayan peso (&#036;)</option>
                                                        <option value="UZS">Uzbekistani som (UZS)</option>
                                                        <option value="VEF">Venezuelan bol&iacute;var (Bs F)</option>
                                                        <option value="VES">Bol&iacute;var soberano (Bs.S)</option>
                                                        <option value="VND">Vietnamese &#x111;&#x1ed3;ng (&#8363;)</option>
                                                        <option value="VUV">Vanuatu vatu (Vt)</option>
                                                        <option value="WST">Samoan t&#x101;l&#x101; (T)</option>
                                                        <option value="XAF">Central African CFA franc (CFA)</option>
                                                        <option value="XCD">East Caribbean dollar (&#036;)</option>
                                                        <option value="XOF">West African CFA franc (CFA)</option>
                                                        <option value="XPF">CFP franc (Fr)</option>
                                                        <option value="YER">Yemeni rial (&#xfdfc;)</option>
                                                        <option value="ZAR">South African rand (&#082;)</option>
                                                        <option value="ZMW">Zambian kwacha (ZK)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="default_currency_format[symbol]" type="text" class="selectize-input" v-model="opts.default_currency_format.symbol">
                                                </td>
                                                <td>
                                                    <select name="default_currency_format[position]" id="" class="selectize-select" v-model="opts.default_currency_format.position" style="min-width: 180px;">
                                                        <option value="{price}">None</option>
                                                        <option value="{symbol}{price}">Left</option>
                                                        <option value="{symbol}{space}{price}">Left with space</option>
                                                        <option value="{price}{symbol}">Right</option>
                                                        <option value="{price}{space}{symbol}">Right with space</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="default_currency_format[thousands_sep]" type="text" class="selectize-input" v-model="opts.default_currency_format.thousands_sep">
                                                </td>
                                                <td>
                                                    <input name="default_currency_format[decimals_sep]" type="text" class="selectize-input" v-model="opts.default_currency_format.decimals_sep">
                                                </td>
                                                <td>
                                                    <input name="default_currency_format[decimals]" type="number" class="selectize-input" v-model="opts.default_currency_format.decimals">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <h3>Currency Formats</h3>
                                </div>
                                <div class="crypto-cols">
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <th>Currency</th>
                                                <th>Symbol</th>
                                                <th>Position</th>
                                                <th>Thousands Sep.</th>
                                                <th>Decimal Sep.</th>
                                                <th>Decimals</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(format, index) in opts.currency_format">
                                                <td>
                                                    <select v-bind:name="'currency_format[' + index + '][iso]'" id="" class="selectize-select" v-model="format.iso">
                                                        <option value="AED">United Arab Emirates dirham (&#x62f;.&#x625;)</option>
                                                        <option value="AFN">Afghan afghani (&#x60b;)</option>
                                                        <option value="ALL">Albanian lek (L)</option>
                                                        <option value="AMD">Armenian dram (AMD)</option>
                                                        <option value="ANG">Netherlands Antillean guilder (&fnof;)</option>
                                                        <option value="AOA">Angolan kwanza (Kz)</option>
                                                        <option value="ARS">Argentine peso (&#036;)</option>
                                                        <option value="AUD">Australian dollar (&#036;)</option>
                                                        <option value="AWG">Aruban florin (Afl.)</option>
                                                        <option value="AZN">Azerbaijani manat (AZN)</option>
                                                        <option value="BAM">Bosnia and Herzegovina convertible mark (KM)</option>
                                                        <option value="BBD">Barbadian dollar (&#036;)</option>
                                                        <option value="BDT">Bangladeshi taka (&#2547;&nbsp;)</option>
                                                        <option value="BGN">Bulgarian lev (&#1083;&#1074;.)</option>
                                                        <option value="BHD">Bahraini dinar (.&#x62f;.&#x628;)</option>
                                                        <option value="BIF">Burundian franc (Fr)</option>
                                                        <option value="BMD">Bermudian dollar (&#036;)</option>
                                                        <option value="BND">Brunei dollar (&#036;)</option>
                                                        <option value="BOB">Bolivian boliviano (Bs.)</option>
                                                        <option value="BRL">Brazilian real (&#082;&#036;)</option>
                                                        <option value="BSD">Bahamian dollar (&#036;)</option>
                                                        <option value="BTC">Bitcoin (&#3647;)</option>
                                                        <option value="BTN">Bhutanese ngultrum (Nu.)</option>
                                                        <option value="BWP">Botswana pula (P)</option>
                                                        <option value="BYR">Belarusian ruble (old) (Br)</option>
                                                        <option value="BYN">Belarusian ruble (Br)</option>
                                                        <option value="BZD">Belize dollar (&#036;)</option>
                                                        <option value="CAD">Canadian dollar (&#036;)</option>
                                                        <option value="CDF">Congolese franc (Fr)</option>
                                                        <option value="CHF">Swiss franc (&#067;&#072;&#070;)</option>
                                                        <option value="CLP">Chilean peso (&#036;)</option>
                                                        <option value="CNY">Chinese yuan (&yen;)</option>
                                                        <option value="COP">Colombian peso (&#036;)</option>
                                                        <option value="CRC">Costa Rican col&oacute;n (&#x20a1;)</option>
                                                        <option value="CUC">Cuban convertible peso (&#036;)</option>
                                                        <option value="CUP">Cuban peso (&#036;)</option>
                                                        <option value="CVE">Cape Verdean escudo (&#036;)</option>
                                                        <option value="CZK">Czech koruna (&#075;&#269;)</option>
                                                        <option value="DJF">Djiboutian franc (Fr)</option>
                                                        <option value="DKK">Danish krone (DKK)</option>
                                                        <option value="DOP">Dominican peso (RD&#036;)</option>
                                                        <option value="DZD">Algerian dinar (&#x62f;.&#x62c;)</option>
                                                        <option value="EGP">Egyptian pound (EGP)</option>
                                                        <option value="ERN">Eritrean nakfa (Nfk)</option>
                                                        <option value="ETB">Ethiopian birr (Br)</option>
                                                        <option value="EUR">Euro (&euro;)</option>
                                                        <option value="FJD">Fijian dollar (&#036;)</option>
                                                        <option value="FKP">Falkland Islands pound (&pound;)</option>
                                                        <option value="GBP">Pound sterling (&pound;)</option>
                                                        <option value="GEL">Georgian lari (&#x20be;)</option>
                                                        <option value="GGP">Guernsey pound (&pound;)</option>
                                                        <option value="GHS">Ghana cedi (&#x20b5;)</option>
                                                        <option value="GIP">Gibraltar pound (&pound;)</option>
                                                        <option value="GMD">Gambian dalasi (D)</option>
                                                        <option value="GNF">Guinean franc (Fr)</option>
                                                        <option value="GTQ">Guatemalan quetzal (Q)</option>
                                                        <option value="GYD">Guyanese dollar (&#036;)</option>
                                                        <option value="HKD">Hong Kong dollar (&#036;)</option>
                                                        <option value="HNL">Honduran lempira (L)</option>
                                                        <option value="HRK">Croatian kuna (kn)</option>
                                                        <option value="HTG">Haitian gourde (G)</option>
                                                        <option value="HUF">Hungarian forint (&#070;&#116;)</option>
                                                        <option value="IDR">Indonesian rupiah (Rp)</option>
                                                        <option value="ILS">Israeli new shekel (&#8362;)</option>
                                                        <option value="IMP">Manx pound (&pound;)</option>
                                                        <option value="INR">Indian rupee (&#8377;)</option>
                                                        <option value="IQD">Iraqi dinar (&#x639;.&#x62f;)</option>
                                                        <option value="IRR">Iranian rial (&#xfdfc;)</option>
                                                        <option value="IRT">Iranian toman (&#x62A;&#x648;&#x645;&#x627;&#x646;)</option>
                                                        <option value="ISK">Icelandic kr&oacute;na (kr.)</option>
                                                        <option value="JEP">Jersey pound (&pound;)</option>
                                                        <option value="JMD">Jamaican dollar (&#036;)</option>
                                                        <option value="JOD">Jordanian dinar (&#x62f;.&#x627;)</option>
                                                        <option value="JPY">Japanese yen (&yen;)</option>
                                                        <option value="KES">Kenyan shilling (KSh)</option>
                                                        <option value="KGS">Kyrgyzstani som (&#x441;&#x43e;&#x43c;)</option>
                                                        <option value="KHR">Cambodian riel (&#x17db;)</option>
                                                        <option value="KMF">Comorian franc (Fr)</option>
                                                        <option value="KPW">North Korean won (&#x20a9;)</option>
                                                        <option value="KRW">South Korean won (&#8361;)</option>
                                                        <option value="KWD">Kuwaiti dinar (&#x62f;.&#x643;)</option>
                                                        <option value="KYD">Cayman Islands dollar (&#036;)</option>
                                                        <option value="KZT">Kazakhstani tenge (KZT)</option>
                                                        <option value="LAK">Lao kip (&#8365;)</option>
                                                        <option value="LBP">Lebanese pound (&#x644;.&#x644;)</option>
                                                        <option value="LKR">Sri Lankan rupee (&#xdbb;&#xdd4;)</option>
                                                        <option value="LRD">Liberian dollar (&#036;)</option>
                                                        <option value="LSL">Lesotho loti (L)</option>
                                                        <option value="LYD">Libyan dinar (&#x644;.&#x62f;)</option>
                                                        <option value="MAD">Moroccan dirham (&#x62f;.&#x645;.)</option>
                                                        <option value="MDL">Moldovan leu (MDL)</option>
                                                        <option value="MGA">Malagasy ariary (Ar)</option>
                                                        <option value="MKD">Macedonian denar (&#x434;&#x435;&#x43d;)</option>
                                                        <option value="MMK">Burmese kyat (Ks)</option>
                                                        <option value="MNT">Mongolian t&ouml;gr&ouml;g (&#x20ae;)</option>
                                                        <option value="MOP">Macanese pataca (P)</option>
                                                        <option value="MRU">Mauritanian ouguiya (UM)</option>
                                                        <option value="MUR">Mauritian rupee (&#x20a8;)</option>
                                                        <option value="MVR">Maldivian rufiyaa (.&#x783;)</option>
                                                        <option value="MWK">Malawian kwacha (MK)</option>
                                                        <option value="MXN">Mexican peso (&#036;)</option>
                                                        <option value="MYR">Malaysian ringgit (&#082;&#077;)</option>
                                                        <option value="MZN">Mozambican metical (MT)</option>
                                                        <option value="NAD">Namibian dollar (&#036;)</option>
                                                        <option value="NGN">Nigerian naira (&#8358;)</option>
                                                        <option value="NIO">Nicaraguan c&oacute;rdoba (C&#036;)</option>
                                                        <option value="NOK">Norwegian krone (&#107;&#114;)</option>
                                                        <option value="NPR">Nepalese rupee (&#8360;)</option>
                                                        <option value="NZD">New Zealand dollar (&#036;)</option>
                                                        <option value="OMR">Omani rial (&#x631;.&#x639;.)</option>
                                                        <option value="PAB">Panamanian balboa (B/.)</option>
                                                        <option value="PEN">Sol (S/)</option>
                                                        <option value="PGK">Papua New Guinean kina (K)</option>
                                                        <option value="PHP">Philippine peso (&#8369;)</option>
                                                        <option value="PKR">Pakistani rupee (&#8360;)</option>
                                                        <option value="PLN">Polish z&#x142;oty (&#122;&#322;)</option>
                                                        <option value="PRB">Transnistrian ruble (&#x440;.)</option>
                                                        <option value="PYG">Paraguayan guaran&iacute; (&#8370;)</option>
                                                        <option value="QAR">Qatari riyal (&#x631;.&#x642;)</option>
                                                        <option value="RON">Romanian leu (lei)</option>
                                                        <option value="RSD">Serbian dinar (&#x434;&#x438;&#x43d;.)</option>
                                                        <option value="RUB">Russian ruble (&#8381;)</option>
                                                        <option value="RWF">Rwandan franc (Fr)</option>
                                                        <option value="SAR">Saudi riyal (&#x631;.&#x633;)</option>
                                                        <option value="SBD">Solomon Islands dollar (&#036;)</option>
                                                        <option value="SCR">Seychellois rupee (&#x20a8;)</option>
                                                        <option value="SDG">Sudanese pound (&#x62c;.&#x633;.)</option>
                                                        <option value="SEK">Swedish krona (&#107;&#114;)</option>
                                                        <option value="SGD">Singapore dollar (&#036;)</option>
                                                        <option value="SHP">Saint Helena pound (&pound;)</option>
                                                        <option value="SLL">Sierra Leonean leone (Le)</option>
                                                        <option value="SOS">Somali shilling (Sh)</option>
                                                        <option value="SRD">Surinamese dollar (&#036;)</option>
                                                        <option value="SSP">South Sudanese pound (&pound;)</option>
                                                        <option value="STN">S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra (Db)</option>
                                                        <option value="SYP">Syrian pound (&#x644;.&#x633;)</option>
                                                        <option value="SZL">Swazi lilangeni (L)</option>
                                                        <option value="THB">Thai baht (&#3647;)</option>
                                                        <option value="TJS">Tajikistani somoni (&#x405;&#x41c;)</option>
                                                        <option value="TMT">Turkmenistan manat (m)</option>
                                                        <option value="TND">Tunisian dinar (&#x62f;.&#x62a;)</option>
                                                        <option value="TOP">Tongan pa&#x2bb;anga (T&#036;)</option>
                                                        <option value="TRY">Turkish lira (&#8378;)</option>
                                                        <option value="TTD">Trinidad and Tobago dollar (&#036;)</option>
                                                        <option value="TWD">New Taiwan dollar (&#078;&#084;&#036;)</option>
                                                        <option value="TZS">Tanzanian shilling (Sh)</option>
                                                        <option value="UAH">Ukrainian hryvnia (&#8372;)</option>
                                                        <option value="UGX">Ugandan shilling (UGX)</option>
                                                        <option value="USD">United States (US) dollar (&#036;)</option>
                                                        <option value="UYU">Uruguayan peso (&#036;)</option>
                                                        <option value="UZS">Uzbekistani som (UZS)</option>
                                                        <option value="VEF">Venezuelan bol&iacute;var (Bs F)</option>
                                                        <option value="VES">Bol&iacute;var soberano (Bs.S)</option>
                                                        <option value="VND">Vietnamese &#x111;&#x1ed3;ng (&#8363;)</option>
                                                        <option value="VUV">Vanuatu vatu (Vt)</option>
                                                        <option value="WST">Samoan t&#x101;l&#x101; (T)</option>
                                                        <option value="XAF">Central African CFA franc (CFA)</option>
                                                        <option value="XCD">East Caribbean dollar (&#036;)</option>
                                                        <option value="XOF">West African CFA franc (CFA)</option>
                                                        <option value="XPF">CFP franc (Fr)</option>
                                                        <option value="YER">Yemeni rial (&#xfdfc;)</option>
                                                        <option value="ZAR">South African rand (&#082;)</option>
                                                        <option value="ZMW">Zambian kwacha (ZK)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input v-bind:name="'currency_format[' + index + '][symbol]'" type="text" class="selectize-input" v-model="format.symbol">
                                                </td>
                                                <td>
                                                    <select v-bind:name="'currency_format[' + index + '][position]'" id="" class="selectize-select" v-model="format.position" style="min-width: 180px;">
                                                        <option value="{price}">None</option>
                                                        <option value="{symbol}{price}">Left</option>
                                                        <option value="{symbol}{space}{price}">Left with space</option>
                                                        <option value="{price}{symbol}">Right</option>
                                                        <option value="{price}{space}{symbol}">Right with space</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input v-bind:name="'currency_format[' + index + '][thousands_sep]'" type="text" class="selectize-input" v-model="format.thousands_sep">
                                                </td>
                                                <td>
                                                    <input v-bind:name="'currency_format[' + index + '][decimals_sep]'" type="text" class="selectize-input" v-model="format.decimals_sep">
                                                </td>
                                                <td>
                                                    <input v-bind:name="'currency_format[' + index + '][decimals]'" type="number" class="selectize-input" v-model="format.decimals">
                                                </td>
                                                <td>
                                                    <div class="coinmc-button coinmc-button-danger coinmc-button-sm" v-on:click="removeFormat(index)">Remove</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br><br>
                                <div class="crypto-cols">
                                    <div href="javascript:void(0);" class="coinmc-button coinmc-button-success" v-on:click="addFormat()">+ Add Format</div>
                                </div>
                            </div>
                        </div>

                        <div id="page-license" class="page-content" v-show="menu==='license'">
                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <p><?php _e('Enter your purchase code below to activate your copy.', 'coinpress'); ?></p>
                                    <p><?php _e('Activating the plugin unlocks additional settings, automatic future updates, and support from developers.', 'coinpress'); ?></p>
                                </div>
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_ticker"><?php _e('Status', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <?php if ($config['license'] != 'regular' && $config['license'] != 'extended') { ?>
                                        <div class="coinmc-badge coinmc-badge-dark"><?php _e('Inactive', 'coinpress'); ?></div><span> - <?php _e('You are not receiving automatic updates', 'coinpress'); ?></span>
                                    <?php } else { ?>
                                    <div class="coinmc-badge coinmc-badge-success"><?php _e('Active', 'coinpress'); ?></div><span> - <?php _e('You are receiving automatic updates', 'coinpress'); ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_ticker"><?php _e('Purchase Code', 'coinpress'); ?> (<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank"><?php _e('where is my purchase code?', 'coinpress'); ?></a>)</label>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" class="selectize-input" name="license_key" v-model="opts.license_key">
                                    <br><br>
                                    <input type="hidden" name="license" v-model="opts.license">
                                    <input type="hidden" class="coinmc-license-action" name="license_action" v-model="opts.license_action">
                                    <?php if ($config['license'] != 'regular' && $config['license'] != 'extended') { ?>
                                    <button type="button" class="coinmc-button coinmc-button-success" v-on:click="license('activate')"><?php _e('Activate', 'coinpress'); ?></button>
                                    <?php } else { ?>
                                    <button type="button" class="coinmc-button coinmc-button-danger" v-on:click="license('deactivate')"><?php _e('Deactivate License', 'coinpress'); ?></button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
                        <div id="page-general" class="page-content" v-show="menu==='general'">

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_ticker"><?php _e("Cryptocurrency Pages", "coinpress"); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e("Cryptocurrency pages where widgets should be linked.", "coinpress"); ?>
                                    <br>
                                    <?php _e("Please note you need to enable links in widget settings.", "coinpress"); ?>
                                    <br>
                                    <?php printf(__('You can use automatically generated coin pages or <a href="%s" target="_blank">create your own pages</a> and link them', 'coinpress'), 'https://www.youtube.com/watch?v=XLF5y0L-seo'); ?></p>
                                </div>
                                <div class="crypto-cols">
                                    <label for="linkto2" class="form-radio">
                                        <input type="radio" class="beaut-radio" name="linkto" id="linkto2" value="coinpress" v-model="opts.linkto" /><i class="form-icon"></i> <?php _e('Coinpress', 'coinpress'); ?>
                                    </label>
                                    <label for="linkto1" class="form-radio">
                                        <input type="radio" class="beaut-radio" name="linkto" id="linkto1" value="custom" v-model="opts.linkto" /><i class="form-icon"></i> <?php _e('Custom Pages', 'coinpress'); ?>
                                    </label>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_currency"><?php _e("Base currency", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <select name="currency" class="selectize-select" v-model="opts.currency">
                                    <?php $currencies = $this->get_currencies();
                                    foreach($currencies as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_font"><?php _e("Font", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <select name="font" class="selectize-select" v-model="opts.font">
                                        <?php foreach ($this->data->fonts as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_changelly"><?php _e("Affiliate Url", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php printf(__('Used for buy and sell links. You can use <a href="%s" target="_blank">changelly</a> affiliate link or your own custom link!', 'coinpress'), 'https://changelly.com/'); ?></p>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" class="selectize-input" name="changelly" v-model="opts.changelly" placeholder="https://old.changelly.com/?ref_id=r0hpb1sy34ucvod4">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_newsfeeds"><?php _e("News Feeds (One per line)", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="news_feeds" class="selectize-input" rows="3"><?php echo str_replace("rn", "\n", $config['news_feeds']); ?></textarea>
                                    <span class="validate-rss">Validate RSS Feeds </span><span class="loader"></span>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <div class="crypto_css"><?php _e('Custom CSS', 'coinpress'); ?></div>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="css" class="selectize-input" id="coinmc-css-editor" rows="5" v-model="opts.css"></textarea>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_sitemap"><?php _e("Sitemap", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <div class="cmc-row between-md">
                                        <div class="cmc-md-8">
                                            <p><?php _e('Generate sitemap file for dynamically generated cryptocurrency pages', 'coinpress'); ?>. <?php _e('You can submit this file to', 'coinpress'); ?> <a href="https://www.google.com/webmasters/" target="_blank">Google Webmaster Tools</a></p>
                                            <?php if ($config['sitemap_update'] > 0) { ?>
                                            <p>
                                                <?php _e('Congratulations! Your sitemap is available at:', 'coinpress'); ?> <a href="<?php echo wp_upload_dir()['baseurl'] . '/coinpress/sitemap.xml'; ?>" target="_blank">sitemap.xml</a>
                                                <br>
                                                <?php _e('Last generated:', 'coinpress'); ?> <b><?php echo $this->time_ago($config['sitemap_update']); ?></b>
                                            </p>
                                            <?php } else if ($config['sitemap_update'] < 0) { ?>
                                            <p>
                                                <?php _e('The directory', 'coinpress'); ?> <b><?php echo COINMC_PATH . 'sitemap'; ?></b> <?php _e('is not writable', 'coinpress'); ?>. <?php _e('Please fix it and try again', 'coinpress'); ?>
                                            </p>
                                            <?php } ?>
                                        </div>
                                        <div class="cmc-md-4 end-md">
                                            <a href="<?php echo admin_url('admin-ajax.php?action=coinpress_sitemap'); ?>" class="coinmc-button coinmc-button-primary"><?php _e('Generate Sitemap', 'coinpress'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_sitemap"><?php _e("Content", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <div class="cmc-row between-md">
                                        <div class="cmc-md-8">
                                            <p><?php _e('If you\'ve lost or changed the coin pages content, you can reset here', 'coinpress'); ?></p>
                                        </div>
                                        <div class="cmc-md-4 end-md">
                                            <a href="<?php echo admin_url('admin-ajax.php?action=coinpress_reload'); ?>" class="coinmc-button coinmc-button-primary"><?php _e('Reload Content', 'coinpress'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_sitemap"><?php _e("Troubleshooting", 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <div class="cmc-row between-md">
                                        <div class="cmc-md-8">
                                            <p><?php _e('If coins data is not right, try clearing cache', 'coinpress'); ?></p>
                                        </div>
                                        <div class="cmc-md-4 end-md">
                                            <a href="<?php echo admin_url('admin-ajax.php?action=coinmc_clear_cache'); ?>" class="coinmc-button coinmc-button-primary"><?php _e('Clear Cache', 'coinpress'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div id="page-api" class="page-content" v-show="menu==='api'">

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_api"><?php _e('Data provided by'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('Changes take effect in about 15 minutes.', 'coinpress'); ?>
                                    <br>
                                    <?php printf(__('Please also update <a href="%s" target="_blank">Massive Cryptocurrency Widgets</a> plugin to latest version and select the same provider if you are using it.', 'coinpress'), 'https://codecanyon.net/item/massive-cryptocurrency-widgets/22093978'); ?></p>
                                </div>
                                <div class="crypto-cols">
                                    <?php 
                                    $providers = apply_filters('mcw_get_providers', $this->providers); 
                                    foreach ($providers as $provider => $img) { ?>

                                    <label for="api-<?php echo $provider; ?>" class="form-radio">
                                    <img height="35" src="<?php echo $img; ?>" alt="">
                                        <input type="radio" class="beaut-radio" name="api" id="api-<?php echo $provider; ?>" value="<?php echo $provider; ?>" v-model="opts.api" /><i class="form-icon"></i>
                                    </label>

                                    <?php } ?>
                                </div>
                            </div>

                            <div class="crypto-rows" v-show="opts.api==='coinmarketcap'">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_api_key"><?php _e('API Key'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" class="selectize-input" name="api_key" v-model="opts.api_key">
                                </div>
                                <div class="crypto-cols">
                                    <p><?php printf(__('Get your Coinmarketcap.com API key <a href="%s" target="_blank">here</a>', 'coinpress'), 'https://coinmarketcap.com/api/'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows" v-show="opts.api==='coinmarketcap'">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_api_interval"><?php _e('Refresh data every'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <select name="api_interval" class="selectize-select" v-model="opts.api_interval">
                                        <option value="300">5 <?php _e('Minutes', 'coinpress'); ?></option>
                                        <option value="600">10 <?php _e('Minutes', 'coinpress'); ?></option>
                                        <option value="1200">20 <?php _e('Minutes', 'coinpress'); ?></option>
                                        <option value="1800">30 <?php _e('Minutes', 'coinpress'); ?></option>
                                        <option value="3600">1 <?php _e('Hour', 'coinpress'); ?></option>
                                        <option value="10800">3 <?php _e('Hours', 'coinpress'); ?></option>
                                        <option value="21600">6 <?php _e('Hours', 'coinpress'); ?></option>
                                        <option value="43200">12 <?php _e('Hours', 'coinpress'); ?></option>
                                        <option value="86400">1 <?php _e('Day', 'coinpress'); ?></option>
                                    </select>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('On average, one call to get latest prices uses 11 api credits. Please calculate optimal refresh interval based on your plan.', 'coinpress'); ?></p>
                                    <p><?php _e('Recommended options: Basic: 1 Hour+, Hobbyist: 20 Minutes+, Startup: 5 Minutes+', 'coinpress'); ?></p>
                                </div>
                            </div>

                        </div>

                        <div id="page-coindetails" class="page-content" v-show="menu==='coindetails'">

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_slug"><?php _e('Link', 'coinpress'); ?></label>
                                    <p>Link to coin names in widgets. Use <code>[symbol]</code> parameter to replace with coin symbol in url.</p>
                                    <b>Examples:</b>
                                    <ul>
                                        <li>/currencies/[symbol]</li>
                                        <li>/token/[symbol]</li>
                                        <li>https://anothersite.com/buy?asset=[symbol]</li>
                                    </ul>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" name="link" class="selectize-input coindt-url-input" v-model="opts.link">
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('After saving, update permalinks in Settings -> Permalinks', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_title"><?php _e('Page Title', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" name="title" class="selectize-input" value="<?php echo esc_html($config['title']); ?>" />
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('used as coin detail page\'s title', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="crypto_desc"><?php _e('Description', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="description" id="" class="selectize-input"><?php echo esc_html($config['description']); ?></textarea>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('Displayed when no description is available. See available placeholders in Shortcodes section', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for=""><?php _e('Meta Description', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="meta_description" class="selectize-input"><?php echo esc_html($config['meta_description']); ?></textarea>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('Default when no meta description is available. See available placeholders in Shortcodes section', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for=""><?php _e('Theme Color', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input type="text" name="theme_color" value="<?php echo $config['theme_color']; ?>" class="selectize-input color-field">
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('Applied for chart color in coin pages', 'coinpress'); ?></p>
                                </div>
                            </div>

                        </div>

                        <div id="page-shortcodes" class="page-content" v-show="menu==='shortcodes'">

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <h4><?php _e('Text Shortcodes', 'coinpress'); ?></h4>
                                    <p><?php _e('Shortcodes which display information without any styling', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="name"]</div>
                                    <p><?php _e('Display coin name', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="symbol"]</div>
                                    <p><?php _e('Display coin symbol', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="rank"]</div>
                                    <p><?php _e('Display coin rank among all cryptocurrencies', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="price"]</div>
                                    <p><?php _e('Display coin price', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="pricebtc"]</div>
                                    <p><?php _e('Display coin price in btc', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="price" realtime="off"]</div>
                                    <p><?php _e('Display coin price without real-time update', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="marketcap"]</div>
                                    <p><?php _e('Display coin marketcap', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="change"]</div>
                                    <p><?php _e('Display coin change percentage in 24 hours, also you can try (1hour, 7days and 30days) by <b>change1h | change7d | change30d</b>', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="changetext"]</div>
                                    <p><?php _e('Display <i>increased</i> or <i>decreased</i> based on 24 hours change percentage, also you can try (1hour, 7days and 30days) by <b>changetext1h | changetext7d | changetext30d</b>', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="volume"]</div>
                                    <p><?php _e('Display coin volume in 24 hours', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="supply"]</div>
                                    <p><?php _e('Display coin available supply', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="totalsupply"]</div>
                                    <p><?php _e('Display coin total supply', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="ath"]</div>
                                    <p><?php _e('Display coin\'s All time high value', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="changeath"]</div>
                                    <p><?php _e('Display coin\'s All time high change rate', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="athdate"]</div>
                                    <p><?php _e('Display coin\'s All time high date', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="dayssinceath"]</div>
                                    <p><?php _e('Display coin\'s number of days since the All time high date', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <h4><?php _e('Global Shortcodes', 'coinpress'); ?></h4>
                                    <p><?php _e('You can display the data from Global Widget, with seperate shortcodes', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="cryptocurrencies"]</div>
                                    <p><?php _e('Display total number of cryptocurrencies', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="total_markets"]</div>
                                    <p><?php _e('Display total number of markets', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="total_marketcap"]</div>
                                    <p><?php _e('Display total marketcap value', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="total_volume"]</div>
                                    <p><?php _e('Display total volume value', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="btc_dominance"]</div>
                                    <p><?php _e('Display btc dominance rate', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <h4><?php _e('Extra Attributes', 'coinpress'); ?></h4>
                                    <p><?php _e('You can also specify coin and currency to get specific data', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="price" coin="bitcoin"]</div>
                                    <p><?php _e('Display bitcoin price', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="marketcap" coin="ethereum" currency="eur"]</div>
                                    <p><?php _e('Display ethereum\'s marketcap in euros', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <h4><?php _e('Advanced Shortcodes', 'coinpress'); ?></h4>
                                    <p><?php _e('Theses shortcodes are styled and are usually a group of components', 'coinpress'); ?></p>
                                </div>
                            </div>
                            
                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="logoname"]</div>
                                    <p><?php _e('Display coin name with logo', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="desc"]</div>
                                    <p><?php _e('Display coin description', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="prices"]</div>
                                    <p><?php _e('Display coin price with stats such as marketcap, volume, and supply', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="chart"]</div>
                                    <p><?php _e('Display advanced chart with line and candlestick data', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="historical"]</div>
                                    <p><?php _e('Display daily historical prices in a table format', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="markets"]</div>
                                    <p><?php _e('Display snapshot of relevant market pairs in exchanges', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="social"]</div>
                                    <p><?php _e('Display twitter and reddit feed', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="news"]</div>
                                    <p><?php _e('Display news feed', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">[coinmc type="comments"]</div>
                                    <p><?php _e('Display facebook comments', 'coinpress'); ?></p>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols">
                                    <div class="code">
                                        [coinmc type="tabs"]<br>
                                        [coinmc-tab icon="fas fa-comment" title="Tab Title"]<br>
                                        Your content..<br>
                                        [/coinmc-tab]<br>
                                        [/coinmc-tabs]
                                    </div>
                                    <p><?php _e('Display specially designed tabs. You can change the icon (Font Awesome 5 Free) and the title', 'coinpress'); ?></p>
                                </div>
                            </div>

                        </div>

                </div>

            </div>

        </div>

    </form>

</template>