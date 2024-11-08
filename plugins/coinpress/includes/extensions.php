<div class="wrap coinmc-extensions">

    <?php
        $addons = array_filter($this->extensions, function($ext) { return ($ext->type == 'addons') ? true : false; });
        $products = array_filter($this->extensions, function($ext) { return ($ext->type == 'products' && $ext->slug !== 'coinpress') ? true : false; });
    ?>

    <div class="cmc-row">
        <div class="cmc-col cmc-md-12 pb-0"><h2><?php _e('Extensions', 'coinpress'); ?></h2></div>
    </div>

    <div class="cmc-row">
    <?php foreach ($addons as $addon) { ?>
        <div class="cmc-col cmc-xs-12 cmc-sm-6 cmc-md-4 cmc-lg-3">
            <div class="panel">
                <a href="<?php echo $addon->link; ?>" target="_blank">
                    <img src="<?php echo $addon->image; ?>">
                    <?php echo (in_array($addon->slug, $read_slugs)) ? '' : '<span class="ribbon">New</span>'; ?>
                </a>
                <div class="panel-content">
                    <h3><?php echo $addon->title; ?></h3>
                    <p><?php echo $addon->desc; ?></p>
                    <div class="cmc-row middle-md mb-0">
                        <div class="cmc-md">
                            <div class="panel-btn dark">$<?php echo $addon->price; ?></div>
                        </div>
                        <div class="cmc-md cmc-md end-md">
                            <a href="<?php echo $addon->link; ?>" target="_blank" class="panel-btn">Get addon</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    </div>

    <div class="cmc-row mb-0">
        <div class="cmc-col cmc-md-12">
            <a href="https://store.blocksera.com/addons/" target="_blank" class="panel-btn">Browse all addons</a>
        </div>
    </div>

    <div class="cmc-row">
        <div class="cmc-col cmc-md-12 pb-0"><h2><?php _e('Products', 'coinpress'); ?></h2></div>
    </div>

    <div class="cmc-row">
    <?php foreach ($products as $product) { ?>
        <div class="cmc-col cmc-xs-12 cmc-sm-6 cmc-md-4 cmc-lg-3">
            <div class="panel">
                <a href="<?php echo $product->link; ?>" target="_blank">
                    <img src="<?php echo $product->image; ?>">
                </a>
                <div class="panel-content">
                    <h3><?php echo $product->title; ?></h3>
                    <p><?php echo $product->desc; ?></p>
                    <div class="cmc-row middle-md mb-0">
                        <div class="cmc-md">
                            <div class="panel-btn dark">$<?php echo $product->price; ?></div>
                        </div>
                        <div class="cmc-md cmc-md end-md">
                            <a href="<?php echo $product->link; ?>" target="_blank" class="panel-btn">Get plugin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    </div>

    <div class="cmc-row mb-0">
        <div class="cmc-col cmc-md-12">
            <a href="https://store.blocksera.com/" target="_blank" class="panel-btn">Browse all products</a>
        </div>
    </div>

</div>