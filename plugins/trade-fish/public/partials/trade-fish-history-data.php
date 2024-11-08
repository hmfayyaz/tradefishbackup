<div class="table-responsive">
<table id="table_1" class="display nowrap data-t data-t wpDataTable wpDataTableID-1" data-described-by='table_1_desc' style="color: white" data-wpdatatable_id="1">
    <thead>
        <tr>
            <th data-class="expand" class=" wdtheader sort ">Date</th>
            <th class=" wdtheader sort " >Asset</th>
            <th class=" wdtheader sort " >Signal</th>
            <th class=" wdtheader sort numdata float cell-green" >Entry Price</th>
            <th class=" wdtheader sort numdata float ">Exit Price</th>
            <th class=" wdtheader sort ">Results</th>
            <th class=" wdtheader sort ">Realised P&amp;L</th>
        </tr>
    </thead>
    <tbody id="table_1_body">
        <?php
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {

                $posts->the_post();
                $opening_price = get_post_meta(get_the_ID(), 'opening_price', true);
                $currency = get_post_meta(get_the_ID(), 'currency', true);
                $closing_price = get_post_meta(get_the_ID(), 'closing_price',true);
                $realised = get_post_meta(get_the_ID(), 'realized_profit_or_loss',true);
                $result = get_post_meta(get_the_ID(),'_signal_result',true);
                $ticker_type = get_post_meta(get_the_ID(),'ticker_type',true);
                $ticker = get_the_title(get_the_ID());
                $signal_value = get_post_meta(get_the_ID(), 'signal_value', true);
                $coin_post_id = get_post_meta(get_the_ID(), '_post_title', true);
                $post_tumbnail = get_the_post_thumbnail_url($coin_post_id, array(20, 20));
	            $closing_date = (get_post_meta(get_the_ID(), 'closing_date', true) != '') ? get_post_meta(get_the_ID(), 'closing_date', true) : '-';
	            $post_modified = $closing_date;
	            $post_modified = str_replace('/','-',$post_modified);
// Try to create a DateTime object using the first format
//	            $date_format1 = DateTime::createFromFormat('Y-m-d H:i:s', $post_modified);
//                if ($date_format1 !== false) {
//
//                }
	            $post_modified = date('d/m/Y',strtotime($post_modified));
                $currency = $currency == '' ? 'USD' : $currency;
                $symbol = $currency == 'EUR' ? '€' : '$';


                if ($realised[0] !== '(' && $realised[strlen($realised) - 1] !== ')') {
                    // If not, add round brackets around the value
                    $realised = '(' . $realised . ')';
                }
                if (strpos($realised, '+') === false ) {
                    if($result == 'correct'){
                        $realised = str_replace('(', '(+', $realised);
                    }
                }
                ?>




            <tr id="table_1_row_0">
                <td style=""><?php echo $post_modified; ?></td>
                <td style=""><?php echo $ticker?></td>
                <td style=""><?php echo $signal_value?></td>
                <td class="cell-green column-entry-price " style="color: <?php echo ($result == 'correct') ? '#02C173' : '#FA6B6B'; ?>!important;"><?php echo $get_currencies[$currency]; ?><?php echo $opening_price?></td>
                <td style=""><?php echo $get_currencies[$currency]; ?><?php echo $closing_price?></td>
                <td class="column-signal-result" style=""><?php echo $result?></td>
                <td style="" class="column-realised-pl"><?php echo $realised?></td>
            </tr>
        <?php

            }
        }
            else{
                echo "No Data Found";
            }
        ?>
    </tbody>
</table>

</div>
