



<div class="ticker_type_div" style="width: 100%;">
    <label for="ticker_type" ">Ticker Type:</label>
    <select name="ticker_type" class="ticker_type" id="ticker_type_<?= $row_number?>">
        <option value="0">Select Type</option>
        <option value="crypto" <?php echo $ticker_type != '' && $ticker_type == 'crypto'? 'selected':''; ?>>Crypto</option>
        <option value="stocks" <?php echo $ticker_type != '' && $ticker_type == 'stocks'? 'selected':''; ?>>Stocks</option>
        <option value="commodities" <?php echo $ticker_type != '' && $ticker_type == 'commodities'? 'selected':''; ?>>Commodities</option>
        <option value="fx" <?php echo $ticker_type != '' && $ticker_type == 'fx'? 'selected':''; ?>>FX</option>
        <option value="indices"<?php echo $ticker_type != '' && $ticker_type == 'indices'? 'selected':''; ?>>Indices</option>
    </select>
</div>
<button class="btn btn-success update-Ticker" data-row-id="<?= $row_number ?>" style="
    margin-top: 40px;
    font-size: 13px;
    float: right;;
"> Update Category </button>
</div>

