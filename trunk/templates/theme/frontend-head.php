<title><?php echo __('Super Easy Stock Manager', 'sesm'); ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="module" src="<?php echo WP_PLUGIN_URL; ?>/super-easy-stock-manager/scripts/sesm-app.js"></script>
<link rel='stylesheet' id='font-awesome-css' href='https://use.fontawesome.com/releases/v5.14.0/css/all.css?wpfas=true‚ type=' text/css' media='all' />
<link rel='stylesheet' id='sesm-css' href="<?php echo WP_PLUGIN_URL; ?>/super-easy-stock-manager/style/sesm-main.css">
<script type="text/javascript">
    var wp_site_url = "<?php echo site_URL(); ?>";
    var historyTemplate = new Object;
    historyTemplate.get = '<?php $t = $this->loadTemplate((WP_PLUGIN_DIR . "/super-easy-stock-manager/templates/theme/frontend-history-item.php"));
                            echo trim(preg_replace('/\s\s+/', ' ', $t)); ?>';
    historyTemplate.update = '<?php $t = $this->loadTemplate(WP_PLUGIN_DIR . "/super-easy-stock-manager/templates/theme/frontend-history-item-update.php");
                                echo trim(preg_replace('/\s\s+/', ' ', $t)); ?>';
    historyTemplate.updatePrice = '<?php $t = $this->loadTemplate(WP_PLUGIN_DIR . "/super-easy-stock-manager/templates/theme/frontend-history-item-update-price.php");
                                    echo trim(preg_replace('/\s\s+/', ' ', $t)); ?>';
    historyTemplate.error = '<?php $t = $this->loadTemplate(WP_PLUGIN_DIR . "/super-easy-stock-manager/templates/theme/frontend-history-item-error.php");
                                echo trim(preg_replace('/\s\s+/', ' ', $t)); ?>';
</script>