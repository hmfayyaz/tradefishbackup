<div class="wrap coinmc-details coingrid">

    <h2><?php _e('Edit Cryptocurrencies', 'coinpress'); ?></h2>

    <div class="crypto-edit">

        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">

            <div class="wrapper">

                <input type="hidden" name="action" value="save_details">
                <input type="hidden" name="coin" value="<?php echo $slug; ?>">
                <input type="hidden" name="page" value="<?php echo admin_url('edit.php?post_type=coinmc&page=coinmc-cryptocurrencies'); ?>">

                <div class="cmc-row no-gutters" style="margin-bottom: 0;">

                    <?php if (isset($_GET['success'])) { ?>
                    <div class="cmc-md-12">
                    <div class="updated notice">
                        <p><?php _e('Changes have been saved!', 'coinpress'); ?></p>
                    </div>
                    </div>
                    <?php } ?>

                    <div class="cmc-lg-3 cmc-md-3 cmc-sm-12 cmc-xs-12">
                        
                        <div class="section-left">

                            <div class="form-control">
                                <label for="coin"><?php _e('Select a coin to edit', 'coinpress'); ?></label>
                            </div>

                            <div class="form-control">
                                <select name="coinselect" class="coin-select">
                                    <?php foreach ($coins as $c) { ?>
                                    <option value="<?php echo $c['slug']; ?>"<?php if ($slug == $c['slug']) { echo ' selected'; } ?> data-extra='{ "symbol": "<?php echo strtolower($c['symbol']); ?>" }'><?php echo $c['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-control">
                                <button class="coinmc-button coinmc-button-primary coinmc-button-block"><?php _e('Save Details', 'coinpress'); ?></button>
                            </div>

                        </div>
                    </div>

                    <div class="section-right cmc-lg-9 cmc-md-9 cmc-sm-12 cmc-xs-12">

                        <div class="page-content">

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="desc"><?php _e('Description', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="desc" id="" class="selectize-input"><?php if ($details) { echo stripslashes($details->description); } ?></textarea>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for=""><?php _e('Meta Description', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <textarea name="meta_desc" class="selectize-input"><?php if ($details) { echo stripslashes($details->meta_description); } ?></textarea>
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="website"><?php _e('Website', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="website" type="text" class="selectize-input" value="<?php if ($details) { echo $details->website; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="explorer"><?php _e('Blockchain Explorer', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="explorer" type="text" class="selectize-input" value="<?php if ($details) { echo $details->explorer; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="facebook"><?php _e('Facebook', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="facebook" type="text" class="selectize-input" value="<?php if ($details) { echo $details->facebook; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="twitter"><?php _e('Twitter', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="twitter" type="text" class="selectize-input" value="<?php if ($details) { echo $details->twitter; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="reddit"><?php _e('Reddit', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="reddit" type="text" class="selectize-input" value="<?php if ($details) { echo $details->reddit; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="youtube"><?php _e('YouTube', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="youtube" type="text" class="selectize-input" value="<?php if ($details) { echo $details->youtube; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="source"><?php _e('Source Code (Git)', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="source" type="text" class="selectize-input" value="<?php if ($details) { echo $details->source; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="whitepaper"><?php _e('White Paper', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <input name="whitepaper" type="text" class="selectize-input" value="<?php if ($details) { echo $details->whitepaper; } ?>">
                                </div>
                            </div>

                            <div class="crypto-rows">
                                <div class="crypto-cols crypto-labels">
                                    <label for="keywords"><?php _e('Keywords', 'coinpress'); ?></label>
                                </div>
                                <div class="crypto-cols">
                                    <p><?php _e('Extra "names" or "aliases" you can use to search in table for this cryptocurrency', 'coinpress'); ?></p>
                                </div>
                                <div class="crypto-cols">
                                    <?php $keywords = explode(',', $coin->keywords); ?>
                                    <select name="keywords[]" id="keyword-selectize" multiple>
                                        <?php foreach ($keywords as $keyword) { ?>
                                            <option value="<?php echo $keyword; ?>" selected><?php echo $keyword; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>