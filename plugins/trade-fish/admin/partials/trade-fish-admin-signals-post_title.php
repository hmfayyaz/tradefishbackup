<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin signal post title aspects of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/admin/partials
 *
 */


?>

<div class="select-coin-type-div" style="width: 50%">
    <label for="select_coin_type">Select Coin</label>
    <select name="select_coin_type" id="select_coin_type">
        <option value="">Select Option</option>
        <option value="new_ticker" <?php echo $selected_coin_type == 'new_ticker' ? 'selected' : '' ?> >New Ticker
        </option>
        <option value="existing_ticker" <?php echo $selected_coin_type == 'existing_ticker' ? 'selected' : '' ?>>
            Existing Ticker
        </option>
    </select>
</div>

<div class="_second_dropdown_div" style="width: 50%; display: none">
    <label for="_second_dropdown">Ticker:</label>
    <select name="_second_dropdown" id="_second_dropdown">
        <?php
        if ($get_post_title != '') {
            ?>
            <option value="<?php echo esc_js($second_dropdown) ?>"
                    selected> <?php echo esc_js($get_post_title) ?></option>
        <?php } ?>
        <!-- Options will be dynamically loaded here -->
    </select>
</div>

<div class="new_coin_div">
    <label for="new_coin_name">Coin Name</label>
    <input type="text" name="new_coin_name" id="new_coin_name"
           value="<?php echo ($get_post_title != '') ? $get_post_title : '' ?>">
    <br>
    <label for="new_coin_shortname">Ticker</label>
    <input type="text" name="new_coin_shortname" id="new_coin_shortname"
           value="<?php echo ($_coin_symbol != '') ? $_coin_symbol : '' ?>">
    <br>
    <div class="form-field term-thumbnail-wrap">
        <label for="coin_thumbnail"><?php _e('Coin Image', 'wh'); ?></label>
        <div id="coin_thumbnail">

            <img src="<?php echo $coin_display_image != '' && !empty($coin_display_image) ? $coin_display_image : 'https://backend.bo2.bodenio.de/wp-content/uploads/woocommerce-placeholder-300x300.png' ?>"
                 width="60px" height="60px">
        </div>
        <div style="line-height: 60px;">
            <input type="hidden" id="coin_thumbnail_id" name="coin_thumbnail_id">
            <button type="button" class="upload_coin_image_button button">Upload/Add image</button>
            <button type="button" class="remove_coin_image_button button" style="display: none;">Remove image</button>
        </div>
    </div>
</div>

<div class="custom_title_div">
    <label>Custom Title:</label>
    <input type="text" id="_custom_title" name="_custom_title"
           value="<?php if ($_custom_title != '' && !empty($_custom_title)) {
               echo $_custom_title;
           } else {
               echo '';
           } ?>">

</div>

<script>
    document.getElementById('titlediv').style.display = 'none';
    jQuery(document).ready(function ($) {
        function handleSelectChange() {
            var selectedOption = $('#select_coin_type').val();
            if (selectedOption === 'existing_ticker') {
                $('._second_dropdown_div').show();
                $('.new_coin_div').css("display", "none");
            } else {
                $('._second_dropdown_div').hide();
                $('.new_coin_div').css("display","flex");
            }
        }
        <?php
        if (($selected_coin_type != '' && !empty($selected_coin_type) || $second_dropdown != '')) {
            ?>
        $('._second_dropdown_div').css("display","block");
        $('.select-coin-type-div').css("display","none");
        $('.new_coin_div').css("display","none");

        <?php
        }
        ?>


        $('#select_coin_type').on('change', function () {
            handleSelectChange();
        });
        // $('#select_coin_type').on('change', function() {
        //     var selectedOption = $(this).val();
        //     // Show/hide _second_dropdown_div based on the selected option
        //     if (selectedOption === 'existing_ticker') {
        //         $('._second_dropdown_div').show()
        //         $('.new_coin_div').hide()
        //     } else {
        //         $('._second_dropdown_div').hide()
        //         $('.new_coin_div').show()
        //
        //     }
        //
        // });


        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            // Create a new span element with the image and text
            var $option = $(
                '<span><img src="' + option.thumbnail + '" class="thumbnail-image" style="height:50px;width:50px"/> ' + option.text + '</span>'
            );
            return $option;
        }

        function appendOptionsToDropdown(options, selectedValue) {
            var dropdown = $('#_second_dropdown');
            dropdown.empty();
            options.forEach(function (option) {
                var isSelected = (option.id == selectedValue);
                var newOption = new Option(option.text, option.id, isSelected, isSelected);
                dropdown.append(newOption);
            });
        }

        $('#_post_title').select2();
        var existingValue = '<?php echo esc_js($second_dropdown); ?>';
        $('#_second_dropdown').select2({
            width: '100%',
            ajax: {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,

                        action: 'get_signals_data',
                        limit: 50
                    };
                },
                processResults: function (data) {
                    if (data) {
                        appendOptionsToDropdown(data.results, existingValue);
                        return {
                            results: data.results
                        };
                    } else {
                        console.error('Invalid data structure:', data);
                        return {
                            results: []
                        };
                    }
                },
                cache: true
            },
            templateResult: formatOption,
            escapeMarkup: function (m) {
                return m;
            },
            // minimumInputLength: 1,
            maximumSelectionLength: 5


        });
        // Delay the setting of the preselected value after initializing Select2
        setTimeout(function () {
            $('#_second_dropdown').trigger('click');
        }, 2000); // You may need to adjust the delay based on your specific scenario

    });


    // Only show the "remove image" button when needed
    if (!jQuery('#coin_thumbnail_id').val()) {
        jQuery('.remove_coin_image_button').hide();
    }

    // Uploading files
    var file_frame;

    jQuery(document).on('click', '.upload_coin_image_button', function (event) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Choose an image',
            button: {
                text: 'Use image'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

            jQuery('#coin_thumbnail_id').val(attachment.id);
            jQuery('#coin_thumbnail').find('img').attr('src', attachment_thumbnail.url);
            jQuery('.remove_coin_image_button').show();
        });

        // Finally, open the modal.
        file_frame.open();
    });

    jQuery(document).on('click', '.remove_coin_image_button', function () {
        jQuery('#coin_thumbnail').find('img').attr('src', 'https://backend.bo2.bodenio.de/wp-content/uploads/woocommerce-placeholder-300x300.png');
        jQuery('#coin_thumbnail_id').val('');
        jQuery('.remove_coin_image_button').hide();
        return false;
    });

    jQuery(document).ajaxComplete(function (event, request, options) {
        if (request && 4 === request.readyState && 200 === request.status
            && options.data && 0 <= options.data.indexOf('action=add-tag')) {

            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
            if (!res || res.errors) {
                return;
            }
            // Clear Thumbnail fields on submit
            jQuery('#coin_thumbnail').find('img').attr('src', 'https://backend.bo2.bodenio.de/wp-content/uploads/woocommerce-placeholder-300x300.png');
            jQuery('#coin_thumbnail_id').val('');
            jQuery('.remove_coin_image_button').hide();
            // Clear Display type field on submit
            jQuery('#display_type').val('');
            return;
        }
    });
</script>