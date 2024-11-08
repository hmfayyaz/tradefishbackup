jQuery(function($) {

    depp.define({
        'chartjs': [coinmc.url + 'assets/public/js/Chart.min.js'],
        'echarts': [coinmc.url + 'assets/public/js/echarts.min.js'],
        'datatable': [coinmc.url + 'assets/public/js/jquery.dataTables.min.js'],
        'responsive': [coinmc.url + 'assets/public/js/dataTables.responsive.min.js'],
        'fixedcol': [coinmc.url + 'assets/public/js/tableHeadFixer.js'],
        'fixedhead': [coinmc.url + 'assets/public/js/dataTables.fixedHeader.min.js'],
        'dragscroll': [coinmc.url + 'assets/public/js/dragscroll.js'],
    });

    // JS equivalent for PHP's number_format
    coinmc.number_format = function(number, decimals, dec_point, thousands_point) {
        if (number == null || !isFinite(number)) {
            return '';
        }
    
        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }
    
        if (!dec_point) {
            dec_point = '.';
        }
    
        if (!thousands_point) {
            thousands_point = ',';
        }
    
        number = parseFloat(number).toFixed(decimals);
    
        number = number.replace(".", dec_point);
    
        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);
    
        return number;
    }

    // Format number based on fiat currency
    coinmc.numberFormat = function(num, iso, shorten = false, decimals = 'auto') {
        num = parseFloat(num);
        var format = (coinmc.currency_format[iso] !== undefined) ? coinmc.currency_format[iso] : coinmc.default_currency_format;

        if (shorten) {
            decimals = format.decimals;
        } else if (decimals == 'auto') {
            decimals = (num >= 1) ? format.decimals : (num < 0.000001 ? 14 : 6);
        } else {
            decimals = parseInt(decimals);
        }

        num = num.toFixed(decimals);

        var index = 0;
        var suffix = '';
        var suffixes = ["", " K", " M", " B", " T"];

        if (shorten) {
            while (num > 1000) {
                num = num / 1000;
                index++;
            }
            suffix = suffixes[index];
        }

        return coinmc.number_format(num, decimals, format.decimals_sep, format.thousands_sep) + suffix;
    }

    // Format price with symbols
    coinmc.priceFormat = function(price, iso, shorten = false, decimals = 'auto') {
        price = parseFloat(price);
        var format = (coinmc.currency_format[iso] !== undefined) ? coinmc.currency_format[iso] : coinmc.default_currency_format;

        price = coinmc.numberFormat(price, iso, shorten, decimals);

        var out = format.position;
        out = out.replace('{symbol}', '<b class="fiat-symbol">' + format.symbol + '</b>');
        out = out.replace('{space}', ' ');
        out = out.replace('{price}', '<span>' + price + '</span>');

        return out;
    }

    coinmc.sprintf = function sprintf(format) {
        var args = Array.prototype.slice.call(arguments, 1);
        var i = 0;
        return format.replace(/%s/g, function() {
            return args[i++];
        });
    }

    coinmc.watchlist = {
        textUpdate: function(state, that, coins){
            var texts = [coinmc.text.addtowatchlist, coinmc.text.removefromwatchlist];
            var text = state ? texts[1] : texts[0];
            that = $(that.popper).length > 0 ? $(that.popper).find('.coinmc-dropdown__item a[data-action="watchlist"]') : that;
            $(that).html('<i class="far fa-star"></i> ' + text);
            $('.coinmc-wlist-btn').html('<i class="far fa-star"></i> ' + coins.length);
        },
        ajax: function(action, coin){
            var datas = {
                action  : 'watchlist',
                process: action,
                coin: coin
            }

            $.ajax( {
                url : coinmc.ajax_url,
                type: 'POST',
                data: datas,
                success: function(results){
                    if(action == 'fetch'){
                        return results['coins'] ? results['coins'] : [];
                    } else if(action == 'setcookie'){
                        window.location = results['redirect_to'];
                    } else {
                        return results;
                    }
                }
            });
        },
        get: function(name, fb) {
            var coins = localStorage.getItem('watchlist.' + name);
            return coins ? JSON.parse(coins) : fb;
        },
        set: function(name, val) {
            localStorage.setItem('watchlist.' + name, JSON.stringify(val));
        },
        addremove: function(name, val, that) {
            if(coinmc.watchlistConfig['user_based'] && !coinmc.watchlistConfig['user']){
                this.ajax('setcookie',val);
            } else {
                var out = true;

                if(coinmc.watchlistConfig['user_based']){
                    var datas = {
                        action  : 'watchlist',
                        process: 'update',
                        coin: val
                    }
                    $.ajax( {
                        url : coinmc.ajax_url,
                        type: 'POST',
                        data: datas,
                        success: function(results){                            
                            coinmc.watchlist.textUpdate(results['action'], that, results['coins']);
                        }
                    });
                } else {
                    var coins = coinmc.watchlist.get('coins', []);

                    var index = coins.indexOf(val);
                    var out = true;
        
                    if (index > -1) {

                        coins.splice(index, 1);
                        out = false;
                    } else {
                        coins.push(val);
                    }
                    this.set('coins', coins);
                    this.textUpdate(out, that, coins);
                }

                return out;
            }
        }
    };

    var realtimes = $('[data-realtime="on"]');

    var socket = new WebSocket('wss://ws.coincap.io/prices?assets=ALL');

    socket.addEventListener('message', function(msg) {
        var prices = JSON.parse(msg.data);

        for (var coin in prices) {
            realtimes.find('[data-live-price="' + coin + '"]').each(function(){
                $(this).realTime(coin, prices[coin]);
            });
        }
    });

    $.fn.realTime = function(coin, priceusd) {
        
        var self = $(this);

        var rate = self.data('rate');
        var coin = self.data('live-price');
        var currency = self.data('currency');
        var timeout = parseInt(self.attr('data-timeout')) || 0;
        var difference = Math.floor(Date.now()) - timeout;

        if (difference > 5000) {
            var price = (currency === 'BTC') ? priceusd / rate : priceusd * rate;
            price = (currency === 'BTC' && coin === 'bitcoin') ? 1 : price;
            price = coinmc.priceFormat(price, currency);

            if (coinmc.title && coinmc.title.indexOf('{price}') !== -1 && coin === coinmc.coin) {
                document.title = coinmc.title.replace('{price}', $(price).text());
            }

            self.html(price);

            if (priceusd > parseFloat(self.attr('data-price'))) {
                self.animateCss('liveup');
            }
            if (priceusd < parseFloat(self.attr('data-price'))) {
                self.animateCss('livedown');
            }

            self.attr('data-price', priceusd);
            self.attr('data-timeout', Math.floor(Date.now()));
        }
    }

    $.fn.extend({
        animateCss: function(animationName, callback) {
            var animationEnd = (function(el) {
                var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
                };
    
                for (var t in animations) {
                if (el.style[t] !== undefined) {
                    return animations[t];
                }
                }
            })(document.createElement('div'));
    
            this.addClass('coinmc-animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('coinmc-animated ' + animationName);
    
                if (typeof callback === 'function') callback();
            });
    
            return this;
        },
    });

    function rgb2hex(rgb){
		rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		return (rgb && rgb.length === 4) ? "#" +
		("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
		("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
		("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	}

    function isBrightness($that){
		var c = rgb2hex($that.css('background-color'));
		var rgb = parseInt(c.substring(1), 16);
		var r = (rgb >> 16) & 0xff;
		var g = (rgb >>  8) & 0xff;
		var b = (rgb >>  0) & 0xff;

		var luma = 0.2126 * r + 0.7152 * g + 0.0722 * b;

		if (luma < 50) {
			$that.addClass('invert-act');
		}
	}

	$.fn.invertable = function() {
        isBrightness($(this));

		var invertList = ['ethereum','ripple','iota','eos','0x','bancor','dentacoin','bibox-token','medishares','santiment','quantstamp','raiden-network-token','pillar','republic-protocol','metal','eidoo','credo','blackmoon','covesting','shivom','suncontract','numeraire','daostack','bitdegree','matryx','faceter','internxt','cryptoping','invacio','chainium','creativecoin','trezarcoin','elcoin-el','jesus-coin','mojocoin','gapcoin','prime-xi','speedcash','veltor','loopring-neo','francs'];

		$(this).find('img').each(function(){
			if(invertList.join('-').toLowerCase().indexOf($(this).attr('alt').toLowerCase()) > -1) {
				$(this).addClass('invertable');
			}

		});
    }
    
    $('.cdt-table.dark').each(function() {
        $(this).invertable();
    });

    $.fn.inView = function() {
        if (!$(this).length > 0) { return false; }

        var win = $(window);
        obj = $(this);
        var scrollPosition = win.scrollTop();
        var visibleArea = win.scrollTop() + win.height();
        var objEndPos = (obj.offset().top + obj.outerHeight());
        return (visibleArea >= objEndPos && scrollPosition <= objEndPos ? true : false);
    };

    $.fn.drawChart = function() {

        var self = $(this);
        
        depp.require('chartjs', function() {

            var rate = (self.data('rate')) ? self.data('rate') : 1;
            var currency = (self.data('currency')) ? self.data('currency') : 'USD';
            var color = self.data('color');
            var gradient = parseInt(self.data('gradient'));
            var border = parseInt(self.data('border'));
            var opacity = parseFloat(self.data('opacity'));
            var values = self.data('points').split(',');

            values = values.map(function(value) {
                return (currency === 'BTC') ? parseFloat(value) / rate : parseFloat(value) * rate;
            });

            var labels = values.map(function(value) {
                var decimals = value >= 1 ? 2 : (value < 0.000001 ? 14 : 6);
                return value.toFixed(decimals);
            });

            background = (background) ? background : color;

            if (gradient === 0) {
                var background = 'rgba(' + color + ',' + opacity + ')';
            } else {
                var background = self[0].getContext('2d').createLinearGradient(0, 0, 0, gradient);
                background.addColorStop(0, 'rgba(' + color + ',0.3)');
                background.addColorStop(1, 'rgba(' + color + ',0)');
            }
        
            var data = {
                labels: labels,
                datasets: [{
                    data: values,
                    fill: true,
                    backgroundColor: background,
                    borderColor: 'rgb(' + color + ')',
                    pointBorderColor: 'rgb(' + color + ')',
                    lineTension: 0.25,
                    pointRadius: 0,
                    borderWidth: border
                }]
            };
            var options = {
                animation: { duration: 500 },
                legend: { display: false },
                scales: { xAxes: [{ display: false }], yAxes: [{ display: false }] },
                tooltips: { mode: 'index', intersect: false, displayColors: false, callbacks: {
                    label: function(tooltipItem, data) {
                        return coinmc.priceFormat(tooltipItem['xLabel'], currency).replace('<b class="fiat-symbol">', '').replace('</b>', '').replace('<span>', '').replace('</span>', '');
                    },
                    title: function(tooltipItem, data) {
                        return false;
                    }
                } },
                hover: { mode: 'nearest', intersect: true },
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 1,
                        bottom: 1
                    }
                }
            };
                
            var chart = new Chart(self[0].getContext("2d"), { type: "line", data: data, options: options });

        });

    }

    $.fn.coinmcTable = function() {

        var self = this;
        var breakpoint = 480;
        var table = self.find('.coinmc-datatable');
        var prevBtn = self.find('.coinmc-previous-btn');
        var nextBtn = self.find('.coinmc-next-btn');
        var allBtn = self.find('.coinmc-all-btn');
        var searchInput = self.find('.coinmc-search');
        var pageInfo = self.find('.dataTables_info');
        var wlistBtn = self.find('.coinmc-wlist-btn');
        var currency = self.find('.coinmc-currency');
        var config = table.data('config');

        var deps = ['datatable'];
        if (config.fixedcol) { deps.push('fixedcol'); }
        if (config.fixedhead) { deps.push('fixedhead'); }
        if (config.responsive) { deps.push('responsive'); } else { deps.push('dragscroll'); }

        depp.require(deps, function() {

            var columns = [], fields = [];

            table.find('thead th').each(function(index) {

                var column = $(this).data('col');

                fields.push(column);

                columns.push({
                    data: column,
                    name: column,
                });

            });

            var fixColumns = ['no', 'rank', 'name'].filter(function(val) {
                return fields.indexOf(val) > -1;
            });

            var options = {
                simple: {
                    dom: 'r<"loader show"><"datatable-scroll"t><"loader loader-footer"><"clear">',
                    displayStart: (config.page - 1) * config.length,
                    order: [],
                    pageLength: config.length,
                    columns: columns,
                    columnDefs: [
                        { targets: 'col-name', className: 'ctrl text-left all' },
                        { targets: 'col-no', className: (config.responsive) ? 'text-left min-tablet-p' : 'text-left', width: '20px', orderable: false, },
                        { targets: 'col-rank', className: (config.responsive) ? 'text-left min-tablet-p' : 'text-left', width: '20px' },
                        { targets: 'col-price_usd', className: 'all' },
                        { targets: 'col-weekly', width: '190px', 'max-width': '190px', className: 'chart-wrapper' },
                        { targets: "col-actions", className: 'all', orderable: false, width: '10px' },
                    ],
                    language: {
                        processing: '',
                        emptyTable: '<div style="text-align: left;">' + coinmc.text.emptytable + '</div>'
                    },
                    
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: coinmc.ajax_url,
                        data: {
                            action: 'coinmc_table',
                            id: self.attr('id').split('-')[1],
                            coins: coinmc.watchlistConfig['user_based'] ? coinmc.watchlist.ajax('fetch', []) : coinmc.watchlist.get('coins', []),
                            watchlist: config.watchlist, // from shortcode atts
                            restrict: coinmc.watchlistConfig['user_based'],
                            currency: currency.val()
                        }
                    },
                    drawCallback: function(oSettings) {

                        table.find('canvas').each(function() {
                            $(this).drawChart();
                        });

                        if (config.realtime) {
                            socket.addEventListener('message', function(msg) {
                                var prices = JSON.parse(msg.data);
                                for (coin in prices) {
                                    table.find('[data-live-price="' + coin + '"]').each(function(){
                                        $(this).realTime(coin, prices[coin]);
                                    });
                                }
                            });
                        }

                    },
                },
                advanced: {
                    fixedHeader: config.fixedhead,
                    processing: true,
                    serverSide: true,                    
                    ajax: {
                        url: coinmc.ajax_url,
                        data: {
                            action: 'coinmc_table',
                            id: self.attr('id').split('-')[1],
                            coins: coinmc.watchlistConfig['user_based'] ? coinmc.watchlist.ajax('fetch', []) : coinmc.watchlist.get('coins', []),
                            watchlist: config.watchlist, // from shortcode atts
                            restrict: coinmc.watchlistConfig['user_based'],
                            currency: currency.val()
                        }
                    },
                    drawCallback: function(oSettings) {

                        var url = new URL(location.href);
                        var page = (oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;

                        if(page > 1) {
                            url.searchParams.set('coins', page);
                        } else {
                            url.searchParams.delete('coins');
                        }

                        history.pushState({}, '', url.href);

                        if (config.realtime) {
                            socket.addEventListener('message', function(msg) {
                                var prices = JSON.parse(msg.data);
                                for (var coin in prices) {
                                    table.find('[data-live-price="' + coin + '"]').each(function(){
                                        $(this).realTime(coin, prices[coin]);
                                    });
                                }
                            });
                        }

                        table.find('canvas').each(function() {
                            $(this).drawChart();
                        });
        
                        table.find('.coinmc-dropdown').each(function() {
                            $(this).coinmcDropdown();
                        });

                        $('.cdt-table.dark').each(function() {
                            $(this).invertable();
                        });
        
                        var prevBtnState = Boolean(oSettings._iDisplayStart !== 0);
                        prevBtn.toggle(prevBtnState);
        
                        var nextBtnState = Boolean(oSettings.fnDisplayEnd() !== oSettings.fnRecordsDisplay());
                        nextBtn.toggle(nextBtnState);

                        var pageInfoText = coinmc.sprintf(coinmc.text.pageinfo, oSettings._iDisplayStart + 1, oSettings.fnDisplayEnd(), oSettings.fnRecordsDisplay());
                        pageInfo.text(pageInfoText);
        
                    },
                    initComplete: function(oSettings) {

                        var datatable = this;
        
                        var inputTimeout;
                        var debounceTime = 400;
        
                        searchInput.on('keyup', function() {
                            clearTimeout(inputTimeout);
                            inputTimeout = setTimeout(function() {
                                datatable.api().search(searchInput.val()).draw();
                            }, debounceTime);
                        });
        
                        prevBtn.click(function() {
                            datatable.api().page('previous').draw('page');
                        });
        
                        nextBtn.click(function() {
                            datatable.api().page('next').draw('page');
                        });

                        if(!coinmc.watchlistConfig['user_based']){
                            var coins = coinmc.watchlist.get('coins', []);
                            wlistBtn.html('<i class="far fa-star"></i> ' + coins.length);
                        }
        
                        wlistBtn.click(function() {
                            $(this).toggleClass('dark', !oSettings.ajax.data.watchlist);
                            oSettings.ajax.data.watchlist = !oSettings.ajax.data.watchlist;
                            oSettings.ajax.data.coins = coinmc.watchlistConfig['user_based'] ? coinmc.watchlist.ajax('fetch', []) : coinmc.watchlist.get('coins', []);;
                            datatable.api().draw();
                        });
        
                        currency.on('change', function() {
                            oSettings.ajax.data.currency = $(this).val();
                            datatable.api().draw();
                        });
        
                        if (!config.responsive) {
                            $('.datatable-scroll').addClass('dragscroll');
                            dragscroll.reset();
                        }

                        if (config.fixedhead) {
                            $('.datatable-scroll').on('scroll', function() {
                                datatable.api().fixedHeader.adjust();
                            });
                        }

                        if (config.fixedcol) {
                            table.tableHeadFixer({ left: fixColumns.length, head: false });
                        }
                    }
                }
            };

            if (config.responsive) {
                options.advanced.responsive = {
                    details: {
                        type: (self.width() < breakpoint) ? 'column' : 'inline',
                        target: 'tr'
                    }
                };
            }

            var dtOptions = $.extend(options['simple'], options[config.type]);
            var tabledt = table.DataTable(dtOptions);

            tabledt.on('responsive-resize', function ( e, datatable, columns ) {
                var index = columns[0] ? 0 : 1;
                var dtr = ['dtr-inline', 'dtr-column'];
                table.find('tr td').removeClass('ctrl');
                table.find('tbody tr').each(function() {
                    $(this).find('td').eq(index).addClass('ctrl');
                });
                table.removeClass('dtr-column dtr-inline');
                table.addClass(dtr[index]);
            });

            tabledt.on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    var loaderpos = self.find('.cdt-table-tools').inView() ? 0 : 1;
                    self.find('.loader').eq(loaderpos).addClass('show');
                } else {
                    self.find('.loader').removeClass('show');
                }
            });

            tabledt.on('responsive-display', function (e) {
                $(e.currentTarget).find('td.child canvas').parent().addClass('chart-wrapper');
                $(e.currentTarget).find('td.child canvas').each(function() {
                    $(this).drawChart();
                });
            });

        });

    }

    tippy('.tippy-tooltip', {
        theme: 'dark',
        arrow: true,
        placement: 'bottom',
        animation: 'shift-away'
    });

    $.fn.coinmcDropdown = function() {

        var self = $(this);
        $(this).find('.coinmc-dropdown__list').css('min-width', self.width() + 'px');

        if (typeof $(this).find('.coinmc-button')[0]._tippy === "undefined") {

            tippy($(this).find('.coinmc-button')[0], {
                placement: $(this).data('position'),
                animation: 'shift-away',
                theme: $(this).data('theme') + ' dropdown',
                trigger: 'click',
                animateFill: false,
                interactive: true,
                inertia: true,
                distance: 5,
                content: $(this).find('.coinmc-dropdown__list')[0],
                onShow: function() {
                    self.addClass('coinmc-dropdown-active');
                },
                onHide: function() {
                    self.removeClass('coinmc-dropdown-active');
                }
            });
    
            var tooltip = $(this).find('.coinmc-button')[0]._tippy;
    
            $(tooltip.popper).find('.coinmc-dropdown__item a').each(function() {
                var action = $(this).data('action');
    
                switch (action) {
                    case 'watchlist':
                        if(!coinmc.watchlistConfig['user_based']){
                            var coins = coinmc.watchlist.get('coins', []);
                            var state = (coins.indexOf($(this).data('value')) > -1) ? true : false;
                            coinmc.watchlist.textUpdate(state, $(this), coins);
                        }
                        break;
                }
            });
    
            $(tooltip.popper).find('.coinmc-dropdown__item a').on('click', function() {
    
                var action = $(this).data('action');
                
                switch (action) {
                    case 'currency':
                        $(tooltip.reference).html($(this).html());
                        self.find('input').val($(this).data('value')).trigger('change');
                        break;
                    case 'watchlist':
                        coinmc.watchlist.addremove('coins', $(this).data('value'), tooltip);
                        break;
                }
                tooltip.hide();
            });

        }

    }

    $.fn.coinmcResize = function() {
        var breakpoint = 'xs';
        var width = (this.find('.cmc-row').length > 0) ? this.find('.cmc-row').eq(0).width() : this.width();

        if (width >= 1200) {
            breakpoint = 'lg';
        } else if (width >= 992) {
            breakpoint = 'md';
        } else if (width >= 768) {
            breakpoint = 'sm';
        } else if (width >= 576) {
            breakpoint = 'xs';
        }

        this.removeClass('cmcl-xs cmcl-sm cmcl-md cmcl-lg').addClass('cmcl-' + breakpoint);
        this.trigger('view');
    }

    $.fn.coinmcTabs = function() {

        var self = this;

        self.find('ul > br').remove();

        self.find('.coinmc-tab').eq(0).addClass('active');
        self.find('.coinmc-tab-content').eq(0).addClass('active');
        self.find('.coinmc-tab-content').eq(0).find('.coinmc-trigger').trigger('view');

        self.find('.coinmc-tab').click(function() {
            self.find('.coinmc-tab').removeClass('active');
            $(this).addClass('active');
    
            var $that = self.find('.coinmc-tab-content').eq($(this).index());
            self.find('.coinmc-tab-content').not($that).slideUp();
            self.find('.coinmc-tab-content').eq($(this).index()).slideDown();
            self.find('.coinmc-tab-content').eq($(this).index()).find('.coinmc-trigger').trigger('view');
        });
    }

    $('.coinmc-chart').one('view', function() {

        var self = $(this);
        if (this.length === 0) { return; }

        depp.require('echarts', function() {

            var chartwrapper = self.find('.chart-wrapper');
            var options = chartwrapper.data('config');
            var opts = $.extend({ type: 'chart', coin: 'bitcoin', symbol: 'BTC', currency: 'USD', period: 'day', theme: 'light', smooth: true, areaColor: 'rgba(112,147,254,0.8)', textColor: '#202328', font: 'inherit' }, options);

            //session storage destroy every 30 minutes
            setInterval(function(){
                if(sessionStorage.length > 0){
                    for (var j = 0; j < sessionStorage.length; j++){
                        if (sessionStorage.key(j).indexOf('mcw-') > -1) {
                            sessionStorage.setItem(sessionStorage.key(j),'');
                        }
                    }
                }
            },1000*60*30);

            var periods = {
                chart: { day: 1, week: 7, month: 30, threemonths: 90, sixmonths: 180, year: 365, all: 'max' },
                candlestick: { hour: 60, day: 24, week: 168, month: 30, threemonths: 90, sixmonths: 180, year: 365, all: 2000 }
            };
            var breakpoint = 320;
            var chart = echarts.init(chartwrapper.get(0));

            var themes = {
                light: {
                    backgroundColor: '#fff',
                    color: (opts.type == 'chart') ? (opts.textColor) != '' ? [opts.textColor] : '#202328' : '#202328',
                    fontFamily: opts.font,
                    chartColors: (opts.type == 'chart') ? [opts.areaColor] : ['rgba(108,130,145,0.2)'],
                    titleColor: (opts.type == 'chart') ? [opts.areaColor] : '#656565',
                    xAxis: '#333333',
                    yAxis: '#333333',
                    border: '#eee'
                },
                dark: {
                    backgroundColor: '#202328',
                    color: (opts.type == 'chart') ? (opts.textColor) != '' ? [opts.textColor] : '#fff'  : '#fff',
                    fontFamily: opts.font,
                    chartColors: (opts.type == 'chart') ? [opts.areaColor] : ['rgba(108,130,145,0.2)'],
                    titleColor: (opts.type == 'chart') ? [opts.areaColor] : '#fff',
                    xAxis: '#dddddd',
                    yAxis: '#dddddd',
                    border: '#202328'
                }
            };
    
            var theme = themes[opts.theme];

            function getOptions() {

                var options = {
                    animation: false,
                    backgroundColor: theme.backgroundColor,
                    color: theme.chartColors,
                    textStyle: { color: theme.color, fontFamily: theme.fontFamily },
                    title : {
                        text: opts.symbol +'/'+ opts.currency,
                        subtext: coinmc.text.periods[opts.period],
                        textStyle: { color: theme.titleColor }
                    },
                    grid: { left: 15, right: 15, top: (chartwrapper.width() > breakpoint) ? 80 : 110, bottom: 10, containLabel: true },
                    tooltip : {
                        trigger: 'axis',
                        backgroundColor: '#fff',
                        extraCssText: 'box-shadow: 1px 0 0 #e6e6e6, -1px 0 0 #e6e6e6, 0 1px 0 #e6e6e6, 0 -1px 0 #e6e6e6, 0 3px 13px rgba(0,0,0,0.08)',
                        textStyle: {
                            color: '#393939'
                        },
                        formatter: function (params) {
        
                            var tooltip = params[0].name;
        
                            if (opts.type == 'chart') {
                                tooltip += '<br/>';
                                tooltip += params[0].marker + coinmc.text.tooltip[0] +': <b>' + coinmc.priceFormat(params[0].value, opts.currency);
                                tooltip += '</b>';
                            } else {
                                tooltip += '<br/>';
                                tooltip += params[0].marker + coinmc.text.tooltip[1] +': <b>' + coinmc.priceFormat(params[0].value[4], opts.currency) + '</b>';
                                tooltip += ' '+ coinmc.text.tooltip[2] +': <b>' + coinmc.priceFormat(params[0].value[3], opts.currency) + '</b>';
                                tooltip += '<br/>';
                                tooltip += params[0].marker + coinmc.text.tooltip[3] +': <b>' + coinmc.priceFormat(params[0].value[2], opts.currency) + '</b>';
                                tooltip += ' '+ coinmc.text.tooltip[4] +': <b>' + coinmc.priceFormat(params[0].value[1], opts.currency) + '</b>';
                                tooltip += '<br/>';
                                tooltip += params[1].marker + coinmc.text.tooltip[5] +': <b>' + coinmc.numberFormat(params[1].value, opts.currency, false, 0) + "</b> " + opts.symbol;
                            }
        
                            return tooltip;
                        }
                    },
                    dataZoom: { show : false, realtime: true, start : 0, end : 100 },
                    xAxis : [],
                    yAxis : [],
                    series : []
                };
        
                if (opts.type == 'chart') {
        
                    options.xAxis.push({
                        type : 'category',
                        boundaryGap : false,
                        axisLabel: {
                            textStyle: {
                                color: theme.xAxis
                            },
                        }
                    });
        
                    options.yAxis.push({
                        type : 'value',
                        scale: true,
                        axisLabel: {
                            textStyle: {
                                color: theme.yAxis
                            },
                            formatter: function(value) {
                                return value == 0 ? 0 : coinmc.numberFormat(value, opts.currency);
                            }
                        },
                        splitLine: {
                            show: false,
                            lineStyle: { color: theme.yAxis, width: 1, type: 'solid' }
                        },
                        boundaryGap: false
                    });
        
                    options.series.push({
                        name: coinmc.text.price,
                        type: 'line',
                        smooth: opts.smooth,
                        itemStyle: { normal: { areaStyle: { type: 'default' } } },
                    });
        
                } else {
        
                    options.xAxis.push({
                        type: 'category',
                        boundaryGap: true,
                        axisTick: { onGap:false },
                        splitLine: {
                            show: false
                        },
                        axisLabel: {
                            textStyle: {
                                color: theme.xAxis
                            },
                        }
                    });
        
                    options.yAxis.push({
                        type : 'value',
                        scale: false,
                        axisLabel: {
                            textStyle: {
                                color: theme.yAxis
                            },
                            formatter: function(value) {
                                return value == 0 ? 0 : coinmc.numberFormat(value, opts.currency);
                            }
                        },
                        splitLine: {
                            show: false
                        },
                        boundaryGap: ['0%', '0%']
                    }, {
                        type : 'value',
                        scale: true,
                        axisLabel: {
                            textStyle: {
                                color: theme.yAxis
                            },
                            formatter: function(value) {
                                return value == 0 ? 0 : coinmc.numberFormat(value, opts.currency);
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: { color: theme.yAxis, width: 1, type: 'solid' }
                        },
                        boundaryGap: ['0%', '0%']
                    });
        
                    options.series.push({
                        name:'OHLC',
                        type:'k',
                        itemStyle: {
                            normal: { color: '#dc3545', color0: '#23BF08' }
                        },
                        yAxisIndex: 1
                    });
        
                    options.series.push({
                        name: coinmc.text.volume,
                        type: 'bar'
                    });
        
                }

                chartwrapper.css('background', theme.backgroundColor);
                chartwrapper.css('border-color', theme.border);

                return options;
            }

            self.find('.coinmc-chart-period .coinmc-filter-button').click(function() {
                self.find('.coinmc-chart-period .coinmc-filter-button').removeClass('active');
                $(this).addClass('active');
                opts.period = $(this).data('period');
                drawChart();
            });

            self.find('.coinmc-chart-type .coinmc-filter-button').click(function() {
                self.find('.coinmc-chart-type .coinmc-filter-button').removeClass('active');
                var chartRange = self.find('.coinmc-chart-period .coinmc-filter-button.active').attr('data-period');                
                $(this).addClass('active');
                opts.type = $(this).data('type');

                if(chartRange == 'hour'){
                    self.find('.coinmc-chart-period .coinmc-filter-button[data-period="day"]').trigger('click');
                } else {
                    drawChart();
                }
            });

            function getData(callback) {
                if (opts.type === 'chart') {

                    var slugReplace = {'truefeedback': 'truefeedbackchain', 'avalanche': 'avalanche-2', 'bnb': 'binancecoin', 'multi-collateral-dai': 'dai', 'polkadot-new': 'polkadot', 'polygon': 'matic-network', 'unus-sed-leo': 'leo-token', 'xrp': 'ripple', 'apecoin-ape': 'apecoin', 'hedera': 'hedera-hashgraph', 'near-protocol': 'near', 'bitcoin-sv': 'bitcoin-cash-sv', 'bittorrent-new': 'bittorrent', 'elrond-egld': 'elrond-erd-2', 'kucoin-token': 'kucoin-shares', 'quant': 'quant-network', 'synthetix': 'havven', 'theta-network': 'theta-token', 'trueusd': 'true-usd', 'enjin-coin': 'enjincoin', 'klaytn': 'klay-token', 'mina': 'mina-protocol', 'neutrino-usd': 'neutrino', 'pancakeswap': 'pancakeswap-token', 'stacks': 'blockstack', 'compound': 'compound-governance-token', 'gatetoken': 'gatechain-token', 'gnosis-gno': 'gnosis', 'green-metaverse-token': 'stepn', 'holo': 'holotoken', 'amp': 'amp-token', 'kyber-network-crystal-v2': 'kyber-network-crystal', 'omg': 'omisego', 'optimism-ethereum': 'optimism', 'reserve-rights': 'reserve-rights-token', 'xinfin': 'xdce-crowd-sale', 'zel': 'zelcash', 'golem-network-tokens': 'golem', 'hive-blockchain': 'hive', 'horizen': 'zencash', 'skale-network': 'skale', 'sxp': 'swipe', 'abbc-coin': 'alibabacoin', 'casper': 'casper-network', 'ceek-vr': 'ceek', 'dogelon': 'dogelon-mars', 'polymath-network': 'polymath', 'sushiswap': 'sushi', 'voyager-token': 'ethos', 'wootrade': 'woo-network', 'conflux-network': 'conflux-token', 'ontology-gas': 'ong', 'pundix-new': 'pundi-x-2', 'ren': 'republic-protocol', 'request': 'request-network', 'xyo': 'xyo-network', 'chromia': 'chromaway', 'constellation': 'constellation-labs', 'function-x': 'fx-coin', 'rlc': 'iexec-rlc', 'bittorrent': 'bittorrent-old', 'counos-x': 'counosx', 'fruits-eco': 'fruits', 'steth': 'staked-ether', 'toncoin': 'the-open-network', 'metisdao': 'metis-token', 'mvl': 'mass-vehicle-ledger', 'safe': 'safe-anwang', 'terra-luna-v2': 'terra-luna-2', 'threshold': 'threshold-network-token', 'wemix': 'wemix-token', 'nest-protocol': 'nest', 'stasis-euro': 'stasis-eurs', 'usdx-kava': 'usdx', 'wrapped-everscale': 'everscale', 'funtoken': 'funfair', 'prom': 'prometeus', 'susd': 'nusd', 'lukso': 'lukso-token', 'shentu': 'certik', 'standard-tokenization-protocol': 'stp-network', 'stormx': 'storm', 'vulcan-forged-pyr': 'vulcan-forged', 'orchid': 'orchid-protocol', 'quarkchain': 'quark-chain', 'aleph-im': 'aleph', 'fetch': 'fetch-ai', 'freeway-token': 'freeway', 'mrweb-finance-v2': 'mrweb-finance', 'myneighboralice': 'my-neighbor-alice', 'rsk-infrastructure-framework': 'rif-token', 'rsk-smart-bitcoin': 'rootstock', 'alpha-finance-lab': 'alpha-finance', 'sologenic': 'solo-coin', 'wirex-token': 'wirex', 'bitmax-token': 'asd', 'defi-pulse-index': 'defipulse-index', 'deso': 'bitclout', 'thundercore': 'thunder-token', 'efforce': 'wozx', 'enzyme': 'melon', 'hunt': 'hunt-token', 'idex': 'aurora-dao', 'jasmy': 'jasmycoin', 'splintershards': 'splinterlands', 'travala': 'concierge-io', 'chrono-tech': 'chronobank', 'flamingo': 'flamingo-finance', 'mstable-usd': 'musd', 'richquack-com': 'richquack', 'star-link': 'starlink', 'super-zero-protocol': 'super-zero', 'syntropy': 'noia-network', 'xenioscoin': 'xenios', 'yearn-finance-ii': 'yearn-finance', 'chimpion': 'banana-token', 'kiltprotocol': 'kilt-protocol', 'truefi-token': 'truefi', 'vegaprotocol': 'vega-protocol', 'wrapped-kardiachain': 'kardiachain', 'dxchain-token': 'dxchain', 'keystone-of-opportunity-knowledge': 'kok', 'moss-coin': 'mossland', 'terra-virtua-kolect': 'the-virtua-kolect', 'wing': 'wing-finance', 'burger-cities': 'burger-swap', 'dia': 'dia-data', 'nash': 'neon-exchange', 'rizon-blockchain': 'rizon'};

                    if (opts.coin in slugReplace) {
                        opts.coin = slugReplace[opts.coin];
                    }

                    var url = 'https://api.coingecko.com/api/v3/coins/';
                    url += opts.coin;
                    url += '/market_chart?vs_currency=usd&days=' + periods.chart[opts.period];

                    var stname = "mcw-" + opts.coin.toLowerCase() + "-usd-chart" +  "-" + opts.period;

                } else {
                    var url = 'https://min-api.cryptocompare.com/data/';
                    url += (opts.period === 'hour') ? 'histominute' : (opts.period === 'day' || opts.period === 'week') ? 'histohour' : 'histoday';
                    url += '?fsym=' + opts.symbol + '&tsym=' + opts.currency;
                    url += (opts.period === 'all') ? '&allData=true' : '&limit=' + periods.candlestick[opts.period];
                    url += '&aggregate=1&extraParams=massivecrypto';

                    var stname = "mcw-" + opts.coin.toLowerCase() + "-" + opts.currency.toLowerCase() +  "-" + opts.period;
                }

                if ((sessionStorage.getItem(stname) === null) || sessionStorage.getItem(stname) == '') {

                    $.get(url, function(data) {
                        sessionStorage.setItem(stname, JSON.stringify(data));
                        return callback(data);
                    }, "json");

                } else {

                    var json = JSON.parse(sessionStorage.getItem(stname));
                    return callback(json);

                }

            }

            function formatAMPM(date) {
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            }

            function formatDate(date){
                var date_format = coinmc.text['date'].split(' ');
                let label = [];

                date_format.map(function(term){
                    switch(term){
                        case 'dd':
                            label.push(date.getDate());
                            break;
                        case 'mm':
                            label.push(coinmc.text.months[date.getMonth()]);
                            break;
                        case 'yy':
                            label.push(date.getFullYear());
                            break;
                    }
                });

                if(date_format.length < 3){
                    return coinmc.text.months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();
                } else {
                    var last = label.pop();
                    return label.join(' ') +', '+last;
                }
            }

            function drawChart() {

                chart.showLoading('default', { text: '', color: theme.titleColor, maskColor: theme.backgroundColor  });

                getData(function(data) {

                    if (data && data.Response != "Error") {
                        $(chart._zr.dom).removeClass('no-data');
                        $('.coinmc-filter-button[data-period="hour"]').hide();

                        var options = getOptions();
                        var labels = [], values = [], volumes = [];

                        if (opts.type === 'chart') {

                            for (i = 0; i < data.prices.length; i++) {
    
                                var date = new Date(data.prices[i][0]);
                                var label = '';
                                label = (opts.period == 'day') ? coinmc.text.months[date.getMonth()] + " " + formatAMPM(date) : formatDate(date);
                                label = (opts.period == 'hour') ? formatAMPM(date) : label;
                                var value = data.prices[i][1] * opts.rate;
    
                                labels.push(label);
                                values.push(value);
                            }
    
                        } else {
                            $('.coinmc-filter-button[data-period="hour"]').show();
                            for (i = 0; i < data.Data.length; i++) {

                                var date = new Date(data.Data[i].time * 1000);
                                var label = '';
                                label = (opts.period == 'day') ? coinmc.text.months[date.getMonth()] + " " + formatAMPM(date) : formatDate(date);
                                label = (opts.period == 'hour') ? formatAMPM(date) : label;

                                var value = (opts.type == 'chart') ? data.Data[i].close : [data.Data[i].close, data.Data[i].open, data.Data[i].low, data.Data[i].high];

                                labels.push(label);
                                values.push(value);
                                volumes.push(data.Data[i].volumefrom);

                            }
                        }

                        options.xAxis[0].data = labels;
                        options.series[0].data = values;

                        if (opts.type == 'candlestick') {
                            var zoomstart = Math.round((periods.candlestick[opts.period] / 60) * 10);
                            var zoomshow = (opts.type == 'candlestick' && zoomstart > 10) ? true : false;

                            options.dataZoom.show = zoomshow;
                            options.dataZoom.start = (opts.period == 'all') ? 0 : zoomstart;
                            options.grid.y2 = (zoomshow) ? 80 : 40;
                            options.series[1].data = volumes;
                        }

                        options.yAxis[0].min = (opts.period == 'all') ? 0 : null;

                        chart.setOption(options, true);
                        chart.hideLoading();

                    } else {

                        $(chart._zr.dom).addClass('no-data');

                    }

                });

            };

            drawChart();

            $(window).on('resize', function(){
                chart.resize();
            });

        });

    });

    $('.coinmc-history').one('view', function() {

        var self = $(this);
        
        depp.require('datatable', function() {

            $.fn.dataTableExt.oPagination.info_buttons = {fnInit:function(e,a,n){var t=e._iDisplayStart+1+" - "+e.fnDisplayEnd()+" of "+e.fnRecordsDisplay(),i=document.createElement("span"),s=document.createElement("span"),o=document.createElement("span");i.appendChild(document.createTextNode(e.oLanguage.oPaginate.sPrevious)),o.appendChild(document.createTextNode(e.oLanguage.oPaginate.sNext)),s.appendChild(document.createTextNode(t)),i.className="paginate_button previous",o.className="paginate_button next",s.className="paginate_button info",a.appendChild(i),a.appendChild(s),a.appendChild(o),$(i).click(function(){e.oApi._fnPageChange(e,"previous"),n(e)}),$(o).click(function(){e.oApi._fnPageChange(e,"next"),n(e)}),$(i).bind("selectstart",function(){return!1}),$(o).bind("selectstart",function(){return!1})},fnUpdate:function(e,a){if(e.aanFeatures.p)for(var n=e.aanFeatures.p,t=0,i=n.length;t<i;t++){var s=n[t].getElementsByTagName("span");s[1].innerText=e._iDisplayStart+1+" - "+e.fnDisplayEnd()+" of "+e.fnRecordsDisplay(),0===e._iDisplayStart?s[0].className="paginate_button previous disabled":s[0].className="paginate_button previous enabled",e.fnDisplayEnd()==e.fnRecordsDisplay()?s[2].className="paginate_button next disabled":s[2].className="paginate_button next enabled"}}};

            var table = self.find('.coinmc-datatable');
            var coin = table.data('coin');
            var currency = table.data('currency');
            var dataset = [];

            function getData(callback) {

                var url = 'https://min-api.cryptocompare.com/data/histoday?fsym=' + coin + '&tsym=' + currency + '&limit=365&aggregate=1&extraParams=massivecrypto';
                var stname = "mcw-" + coin.toLowerCase() + "-" + currency.toLowerCase() +  "-year";

                if ((sessionStorage.getItem(stname) === null) || sessionStorage.getItem(stname) == '') {

                    $.get(url, function(data) {
                        sessionStorage.setItem(stname, JSON.stringify(data));
                        return callback(data);
                    }, "json");

                } else {
                    var json = JSON.parse(sessionStorage.getItem(stname));
                    return callback(json);
                }

            }

            var columns = [], fields = [];
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            table.find('thead th').each(function(index) {

                var column = $(this).data('col');
                fields.push(column);

                columns.push({
                    data: column,
                    name: column,
                    render: function(data, type, row, meta) {

                        if (type === 'sort') {
                            return data;
                        }

                        switch (column) {
                            case 'date':
                                var date = new Date(data * 1000);
                                return coinmc.text.months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
                            case 'open':
                            case 'close':
                            case 'high':
                            case 'low':
                            case 'volume':
                                return coinmc.priceFormat(data, currency);
                            default:
                                return data;
                        }
                        
                    }
                });

            });

            function drawTable() {

                getData(function(data) {

                    for (i = 0; i < data.Data.length; i++) {
                        dataset.push({
                            'date': data.Data[i].time,
                            'open': data.Data[i].open,
                            'close': data.Data[i].close,
                            'high': data.Data[i].high,
                            'low': data.Data[i].low,
                            'volume': data.Data[i].volumeto,
                        });
                    }

                    var filtered = dataset.slice(-30);

                    var tabledt = table.DataTable({
                        dom: 'r<"datatable-scroll"t><"loader"><"dataTables-footer"lp><"clear">',
                        scrollX: true,
                        data: filtered,
                        columns: columns,
                        columnDefs: [
                            { targets: 'col-date', className: 'text-left' }
                        ],
                        order: [[0, 'desc']],
                        pageLength: 10,
                        pagingType: 'info_buttons',
                        language: {
                            processing: '',
                            lengthMenu: coinmc.text.lengthmenu + " _MENU_",
                            paginate: {
                                next: coinmc.text.nextbtn,
                                previous: coinmc.text.prevbtn
                            }
                        }
                    });

                    $(".dateselector").flatpickr({
                        mode: 'range',
                        static: true,
                        minDate: new Date().fp_incr(-365),
                        maxDate: 'today',
                        dateFormat: "Y-m-d",
                        defaultDate: [new Date().fp_incr(-30), 'today'],
                        onChange: function(dates, datestr) {

                            dates = datestr.split(' to ');

                            var start = new Date(dates[0]).getTime() / 1000;
                            var end = dates[1] ? new Date(dates[1]).getTime() / 1000 : start;

                            var filtered = dataset.filter(function(data) {
                                return (data.date >= start && data.date <= end)
                            });

                            tabledt.clear();
                            tabledt.rows.add(filtered);
                            tabledt.draw();
                        }
                    });

                });
            }

            drawTable();

        });

    });

    $('.coinmc-markets').one('view', function() {

        var self = $(this);

        depp.require('datatable', function() {

            $.fn.dataTableExt.oPagination.info_buttons = {fnInit:function(e,a,n){var t=e._iDisplayStart+1+" - "+e.fnDisplayEnd()+" of "+e.fnRecordsDisplay(),i=document.createElement("span"),s=document.createElement("span"),o=document.createElement("span");i.appendChild(document.createTextNode(e.oLanguage.oPaginate.sPrevious)),o.appendChild(document.createTextNode(e.oLanguage.oPaginate.sNext)),s.appendChild(document.createTextNode(t)),i.className="paginate_button previous",o.className="paginate_button next",s.className="paginate_button info",a.appendChild(i),a.appendChild(s),a.appendChild(o),$(i).click(function(){e.oApi._fnPageChange(e,"previous"),n(e)}),$(o).click(function(){e.oApi._fnPageChange(e,"next"),n(e)}),$(i).bind("selectstart",function(){return!1}),$(o).bind("selectstart",function(){return!1})},fnUpdate:function(e,a){if(e.aanFeatures.p)for(var n=e.aanFeatures.p,t=0,i=n.length;t<i;t++){var s=n[t].getElementsByTagName("span");s[1].innerText=e._iDisplayStart+1+" - "+e.fnDisplayEnd()+" of "+e.fnRecordsDisplay(),0===e._iDisplayStart?s[0].className="paginate_button previous disabled":s[0].className="paginate_button previous enabled",e.fnDisplayEnd()==e.fnRecordsDisplay()?s[2].className="paginate_button next disabled":s[2].className="paginate_button next enabled"}}};

            var table = self.find('.coinmc-datatable');
            var coin = table.data('coin');
            var currency = table.data('currency');

            function getData(callback) {
                currency = currency == 'USD' ? 'USDT' : currency;
                var url = 'https://min-api.cryptocompare.com/data/top/exchanges/full?fsym=' + coin + '&tsym=' + currency + '&limit=50';
                var stname = "cmc-market-" + coin.toLowerCase() + "-" + currency.toLowerCase();

                if ((sessionStorage.getItem(stname) === null) || sessionStorage.getItem(stname) == '') {

                    $.get(url, function(data) {
                        sessionStorage.setItem(stname, JSON.stringify(data));
                        return callback(data);
                    }, "json");

                } else {
                    var json = JSON.parse(sessionStorage.getItem(stname));
                    return callback(json);
                }

            }

            var columns = [];

            table.find('thead th').each(function(index) {

                var column = $(this).data('col');

                columns.push({
                    data: column,
                    name: column,
                    render: function(data, type, row, meta) {

                        if (type === 'sort') {
                            return data;
                        }

                        switch (column) {
                            case 'change':
                                return data.toFixed(2) + '%';
                            case 'volume':
                            case 'price':
                                return coinmc.priceFormat(data, currency);
                            case 'update':
                                return timeago().format(new Date(data * 1000));
                            default:
                                return data;
                        }
                        
                    }
                });

            });

            function drawTable() {

                getData(function(data) {
                    var dataset = [];
                    if(data.Data.Exchanges == null) return;
                    for (var i = 0; i < data.Data.Exchanges.length; i++) {
                        var ex = data.Data.Exchanges[i];
                        dataset.push({
                            'rank': i + 1,
                            'source': ex.MARKET,
                            'pair': ex.FROMSYMBOL + '/' + ex.TOSYMBOL,
                            'volume': ex.VOLUME24HOURTO,
                            'price': ex.PRICE,
                            'change': ex.CHANGE24HOUR,
                            'update': ex.LASTUPDATE
                        });
                    }

                    table.DataTable({
                        dom: 'r<"datatable-scroll"t><"loader"><"dataTables-footer"lp><"clear">',
                        scrollX: true,
                        data: dataset,
                        columns: columns,
                        columnDefs: [
                            { targets: 'col-rank', className: 'text-left' },
                            { targets: 'col-source', className: 'text-left' }
                        ],
                        order: [],
                        pageLength: 10,
                        pagingType: 'info_buttons',
                        language: {
                            processing: '',
                            lengthMenu: coinmc.text.lengthmenu + " _MENU_",
                            paginate: {
                                next: coinmc.text.nextbtn,
                                previous: coinmc.text.prevbtn
                            }
                        }
                    });

                });

            }

            drawTable();

        });
    });

    $('.coinmc-watchlist').on('click', function(){
        coinmc.watchlist.addremove('coins', $(this).data('value'), $(this));
    });

    $.fn.coinmcCalculator = function() {

        var self = this;

        self.find('.coinmc-form-swap').click(function() {
            self.find('.cmc-row').eq(0).toggleClass('reverse');
        });

        var optionone = self.find('input.coinmc-dropdown__input').first();
        var optiontwo = self.find('input.coinmc-dropdown__input').last();
        var fieldone = self.find('input.coinmc-field').first();
        var fieldtwo = self.find('input.coinmc-field').last();
        var currencybtn = self.find('.coinmc-button').last();
        var direction = 'down';

        fieldone.on('input', function() {
            calcdown();
        });

        fieldtwo.on('input', function() {
            calcup();
        });

        optionone.change(function() {
            calcup(); direction = 'up';
        });

        optiontwo.change(function() {
            calcdown(); direction = 'down';
        });

        function calcdown() {
            var out = '', val = parseFloat(fieldone.val().replace(/,/g, ''));
            out = (val) ? coinmc.numberFormat(val * optionone.val() * optiontwo.val(), currencybtn.html()) : '';
            fieldtwo.val(out);
        }

        function calcup() {
            var out = '', val = parseFloat(fieldtwo.val().replace(/,/g, ''));
            out = (val) ? coinmc.numberFormat((val * (1 / optiontwo.val())) / optionone.val(), currencybtn.html()) : '';
            fieldone.val(out);
        }
        
    }


    if ($('.coinmc-twitter').length == 0 && $('.coinmc-reddit').length == 0) {
        var index = $('.coinmc-social').closest('.coinmc-tab-content').index();
        $('.coinmc-tab-content').eq(index).remove();
        $('.coinmc-tab').eq(index).remove();
        $('.coinmc-tabs').each(function() {
            $(this).coinmcTabs();
        });
    }

    $('.coinmc-twitter').one('view', function() {
        var handle = $(this).data('handle');
        var embed = '<a class="twitter-timeline" href="https://twitter.com/' + handle + '">Tweets by @' + handle + '</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
        $(this).append(embed);
    });

    $('.coinmc-reddit').one('view', function() {
        var self = $(this);
        var url = $(this).data('sub');

        $.ajax({
            type: 'GET',
            data: { action: 'reddit', sub: url },
            url: coinmc.ajax_url,
            success: function(data) {
                self.append(data);
            }
        });
    });

    $('.coinmc-ticker').each(function() {
        $(this).click(function() {
            $(this).toggleClass('single');
        });

        if ($(this).hasClass('coinmc-header')) {
            $('body').css('padding-top', $(this).height() + 'px');
            $('#wpadminbar').css('margin-top', $(this).height() + 'px');
        }
    });

    $('.coinmc-table').each(function() {
        $(this).coinmcTable();
    });

    $('.coinmc-dropdown').not('td .coinmc-dropdown').each(function() {
        $(this).coinmcDropdown();
    });

    $('.coinmc-calculator').each(function() {
        $(this).coinmcCalculator();
    });

    $('.coinmc-tabs').each(function() {
        $(this).coinmcTabs();
    });

    $('.coinmc-trigger').each(function() {
        if ($(this).parents(".coinmc-tabs-content").length == 0) { 
            $(this).trigger('view');
        }
    });

    $('.coingrid').each(function() {
        var self = this;
        $(this).coinmcResize();

        $(window).resize(function() {
            $(self).coinmcResize();
        });
    });

    function autocenter(elem){
        var windowWidth = $(window).outerWidth(true);

        if(windowWidth < 768)
        {
            var container  = $(elem).closest('.coinmc-filter');
            var cWidth     = $(container).outerWidth(true);
            var width      = $(elem).outerWidth(true);
            var offset     = $(elem).offset().left - $($(container).find('.coinmc-filter-button')[0]).offset().left;

            $(container).stop().animate({
                scrollLeft: offset - cWidth/2 + width/2
            }, 400);
        }
    }
    
    if($('.coinmc-filter-button').length > 0){

        autocenter($('.coinmc-chart-period .coinmc-filter-button.active'));
    }

    $('.coinmc-chart-period .coinmc-filter-button').on('click', function(e){
        e.preventDefault();
        autocenter($(this));
    });

    $(document).on('click', '.watchlist-notice .close', function(e){
        $(this).closest('.watchlist-notice').addClass('hidden');
    });

});