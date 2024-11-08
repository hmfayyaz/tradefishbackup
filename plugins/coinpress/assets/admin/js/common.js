/*!
	autosize 4.0.2
	license: MIT
	http://www.jacklmoore.com/autosize
*/
(function(global,factory){if(typeof define==="function"&&define.amd){define(['module','exports'],factory)}else if(typeof exports!=="undefined"){factory(module,exports)}else{var mod={exports:{}};factory(mod,mod.exports);global.autosize=mod.exports}})(this,function(module,exports){'use strict';var map=typeof Map==="function"?new Map():function(){var keys=[];var values=[];return{has:function has(key){return keys.indexOf(key)>-1},get:function get(key){return values[keys.indexOf(key)]},set:function set(key,value){if(keys.indexOf(key)===-1){keys.push(key);values.push(value)}},delete:function _delete(key){var index=keys.indexOf(key);if(index>-1){keys.splice(index,1);values.splice(index,1)}}}}();var createEvent=function createEvent(name){return new Event(name,{bubbles:true})};try{new Event('test')}catch(e){createEvent=function createEvent(name){var evt=document.createEvent('Event');evt.initEvent(name,true,false);return evt}}function assign(ta){if(!ta||!ta.nodeName||ta.nodeName!=='TEXTAREA'||map.has(ta)){return}var heightOffset=null;var clientWidth=null;var cachedHeight=null;function init(){var style=window.getComputedStyle(ta,null);if(style.resize==='vertical'){ta.style.resize='none'}else if(style.resize==='both'){ta.style.resize='horizontal'}if(style.boxSizing==='content-box'){heightOffset= -(parseFloat(style.paddingTop)+parseFloat(style.paddingBottom))}else{heightOffset=parseFloat(style.borderTopWidth)+parseFloat(style.borderBottomWidth)}if(isNaN(heightOffset)){heightOffset=0}update()}function changeOverflow(value){{var width=ta.style.width;ta.style.width='0px';ta.offsetWidth;ta.style.width=width};ta.style.overflowY=value}function getParentOverflows(el){var arr=[];while(el&&el.parentNode&&el.parentNode instanceof Element){if(el.parentNode.scrollTop){arr.push({node:el.parentNode,scrollTop:el.parentNode.scrollTop})}el=el.parentNode}return arr}function resize(){if(ta.scrollHeight===0){return}var overflows=getParentOverflows(ta);var docTop=document.documentElement&&document.documentElement.scrollTop;ta.style.height='';ta.style.setProperty("height",ta.scrollHeight+heightOffset+'px',"important");clientWidth=ta.clientWidth;overflows.forEach(function(el){el.node.scrollTop=el.scrollTop});if(docTop){document.documentElement.scrollTop=docTop}}function update(){resize();var styleHeight=Math.round(parseFloat(ta.style.height));var computed=window.getComputedStyle(ta,null);var actualHeight=computed.boxSizing==='content-box'?Math.round(parseFloat(computed.height)):ta.offsetHeight;if(actualHeight<styleHeight){if(computed.overflowY==='hidden'){changeOverflow('scroll');resize();actualHeight=computed.boxSizing==='content-box'?Math.round(parseFloat(window.getComputedStyle(ta,null).height)):ta.offsetHeight}}else{if(computed.overflowY!=='hidden'){changeOverflow('hidden');resize();actualHeight=computed.boxSizing==='content-box'?Math.round(parseFloat(window.getComputedStyle(ta,null).height)):ta.offsetHeight}}if(cachedHeight!==actualHeight){cachedHeight=actualHeight;var evt=createEvent('autosize:resized');try{ta.dispatchEvent(evt)}catch(err){}}}var pageResize=function pageResize(){if(ta.clientWidth!==clientWidth){update()}};var destroy=function(style){window.removeEventListener('resize',pageResize,false);ta.removeEventListener('input',update,false);ta.removeEventListener('keyup',update,false);ta.removeEventListener('autosize:destroy',destroy,false);ta.removeEventListener('autosize:update',update,false);Object.keys(style).forEach(function(key){ta.style[key]=style[key]});map.delete(ta)}.bind(ta,{height:ta.style.height,resize:ta.style.resize,overflowY:ta.style.overflowY,overflowX:ta.style.overflowX,wordWrap:ta.style.wordWrap});ta.addEventListener('autosize:destroy',destroy,false);if('onpropertychange'in ta&&'oninput'in ta){ta.addEventListener('keyup',update,false)}window.addEventListener('resize',pageResize,false);ta.addEventListener('input',update,false);ta.addEventListener('autosize:update',update,false);ta.style.overflowX='hidden';ta.style.wordWrap='break-word';map.set(ta,{destroy:destroy,update:update});init()}function destroy(ta){var methods=map.get(ta);if(methods){methods.destroy()}}function update(ta){var methods=map.get(ta);if(methods){methods.update()}}var autosize=null;if(typeof window==='undefined'||typeof window.getComputedStyle!=='function'){autosize=function autosize(el){return el};autosize.destroy=function(el){return el};autosize.update=function(el){return el}}else{autosize=function autosize(el,options){if(el){Array.prototype.forEach.call(el.length?el:[el],function(x){return assign(x,options)})}return el};autosize.destroy=function(el){if(el){Array.prototype.forEach.call(el.length?el:[el],destroy)}return el};autosize.update=function(el){if(el){Array.prototype.forEach.call(el.length?el:[el],update)}return el}}exports.default=autosize;module.exports=exports['default']});

jQuery(document).ready(function() {

    $ = jQuery.noConflict();

    var select = $('#select-beast').selectize({
        dataAttr: 'data-extra',
        searchField: ['symbol', 'text'],
        score: function (search) {
            return function (option) {
                search = search.toLowerCase();
                return (option.symbol == search) ? 2 : (option.text.toLowerCase().indexOf(search) !== -1 || option.symbol.indexOf(search) !== -1) ? 1 : 0;
            }
        },
        plugins: ['drag_drop', 'remove_button'],
        delimiter: ',',
        persist: false,
        create: false
    });

    var selectcols = $('#coinmc_tablecols').selectize({
        labelField: 'label',
        valueField: 'value',
        searchField: ['label','value'],
        plugins: ['drag_drop', 'remove_button'],
        delimiter: ',',
        persist: false,
        create: false
    });

    var keywordcols = $('#keyword-selectize').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: true
    });

    $('.removecoins').click(function() {
        select[0].selectize.clear();
    });

    $('.removecols').click(function() {
        selectcols[0].selectize.clear();
    });

    $('input[type=radio][name=global_position]').change(function() {
        $('.global-position-label').removeClass('selected');
        $(this).parent().addClass('selected');
    });

    $('input[type=radio][name=global_color]').change(function() {
        $('input[type=radio][name=global_color]').parent().removeClass('cc-active');
        $(this).parent().addClass('cc-active');
    });

    $('input[type=radio][name=type]').change(function() {
        $('.crypto-toggle').addClass('cc-hide');
        $('.' + this.value + '-position').removeClass('cc-hide');
    });

    $('#coinmcshortcode').on('click', function () {
        $('.shortcode-hint').show().delay(1000).fadeOut();
    });
    var cp = new ClipboardJS('#coinmcshortcode');

    $('input[type=radio][name=table_style]').change(function() {
        $('input[type=radio][name=table_style]').parent().removeClass('cc-active');
        $(this).parent().addClass('cc-active');
    });

    $('.color-field').spectrum({
        type: "component",
        hideAfterPaletteSelect: "true",
        showInput: "true"
    });

    $('.crypto-collapse').click(function() {
        $('.crypto-edit').toggleClass('collapsed');
        setTimeout(function() {
            $(window).trigger('resize');
        }, 250);
    });

    // validate rss feeds    
    $(document).on('click', '.validate-rss', function()
    {
        var $this = $(this);
        var urls = $this.closest('.crypto-cols').find('[name="news_feeds"]').val();
        
        if(urls == ''){
            $this.closest('.crypto-cols').find('[name="news_feeds"]').focus();
            return false;
        }

        $this.closest('.crypto-cols').find('.loader').addClass('active');
        var data = {
            rss_feeds: urls,
            action: 'validate_rss'
        };

        $.ajax({
            url: coinmc.ajax_url, 
            type: "POST",
            dataType: "json",
            data: data,
            success: function(result)
            {
                $this.closest('.crypto-cols').find('.loader').removeClass('active');
                if(result['status'] == 'invalid' && result['invalid'].length > 0){
                    alert('These URLs are invalid \n'+result['invalid'].join("\n"));
                } else if(result['status'] == 'sucess'){
                    alert('All URLs are valid');
                }
                if (result == 0){
                    alert('Validation Terminated');
                }
                
            }
        });
    });

    $.fn.rangeSlider = function() {
        var range = this.find('.range-slider__range');
        var value = this.find('.range-slider__value');
        range.on('input', function() {
            value.html(this.value + value.data('suffix'));
        });
    }

    $('.range-slider').each(function() {
        $(this).rangeSlider();
    });

    autosize($('textarea.selectize-input'));

    $('.coingrid').one('view', function() {
        autosize.update($('textarea.selectize-input'));
    });

    $('.coin-select').selectize({
        dataAttr: 'data-extra',
        searchField: ['symbol', 'text'],
        score: function (search) {
            return function (option) {
                search = search.toLowerCase();
                return (option.symbol == search) ? 2 : (option.text.toLowerCase().indexOf(search) !== -1 || option.symbol.indexOf(search) !== -1) ? 1 : 0;
            }
        },
        onChange: function(val) {
            if (val != "") {
                window.location = $('input[name=page]').val() + '&coin=' + val;
            }
        }
    });

    function coinmcBreakpoint(width) {
        var breakpoint = 'xs';

        if (width >= 992) {
            breakpoint = 'lg';
        } else if (width >= 768) {
            breakpoint = 'md';
        } else if (width >= 576) {
            breakpoint = 'sm';
        }

        return breakpoint;
    }

    $('.coinmc-extensions').removeClass('cmcl-xs cmcl-sm cmcl-md cmcl-lg').addClass('cmcl-' + coinmcBreakpoint($('.wrap').width()));

    $(window).resize(function() {
        $('.coinmc-extensions').removeClass('cmcl-xs cmcl-sm cmcl-md cmcl-lg').addClass('cmcl-' + coinmcBreakpoint($('.wrap').width()));
    });

    Vue.component('coinmc-settings', {
        template: '#coinmc-settings-template',
        props: ['options'],
        data: function() {
            var data = {
                menu: '',
                opts: this.options,
            };
            return data;
        },
        mounted() {
            var self = this;
            self.$data.menu = $('ul.page-menu').find('li').eq(0).data('page');

            var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
            editorSettings.codemirror = _.extend({}, editorSettings.codemirror, {
                indentUnit: 4,
                tabSize: 2,
                mode: 'css',
                autoRefresh: true
            });
            var editor = wp.codeEditor.initialize($('#coinmc-css-editor'), editorSettings);

            $('.color-field').spectrum({
                type: "component",
                hideAfterPaletteSelect: "true",
                showInput: "true"
            });
        },
        methods: {
            toggleMenu: function(menu) {
                this.$data.menu = menu;
            },
            license: function(action) {
                this.$data.opts.license_action = action;
                setTimeout(function() {
                    $('#coinmc-settings-form').submit();
                }, 0);
            },
            addFormat: function() {
                this.$data.opts.currency_format.push(this.$data.opts.default_currency_format);
            },
            removeFormat: function(index) {
                this.$data.opts.currency_format.splice(index, 1);
            }
        }
    });

    var app = new Vue({
        el: '.vue-component',
        props: {
            options: Object
        }
    });

});