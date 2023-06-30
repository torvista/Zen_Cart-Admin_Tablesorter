<?php

declare(strict_types=1);
/**
 * This file should be included from a custom javascript file such as /javascript/banner_manager_extra.php containing:
 * include 'tablesorter_loader.php';
 * For each page where use is required, add the corresponding case and parameters in the switch
 *
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * https://github.com/torvista/Zen_Cart-Admin_Tablesorter
 * @version torvista 30 June 2023
 */
if (!empty($current_page)) {
    $tablesorter_path = 'includes/javascript/tablesorter/dist/'; // path to tablesorter distribution
    $tablesorter_theme = 'css/theme.default.min.css';

    $class_to_remove = '';
    $debug_tsl = false;
    $compact_table = false; // false: do not modify class for table width / true: reduce to fit contents
    $scriptList = ['includes/javascript/tablesorter/dist/js/jquery.tablesorter.min.js']; // minimum javascript required
    $tablesorter_parameters = "widgets: ['zebra'],"; // default parameter
    $table_selector = 'table'; // use the table tag if only one table on the page, otherwise use an id

    // add each admin page as required
    switch (true) {
        case ($current_page === 'banner_manager.php'):
            $class_to_remove = 'table table-hover table-striped';
            break;

        case ($current_page === 'option_values.php' && isset($_GET['options_id'])):
            $scriptList[] = $tablesorter_path . 'js/parsers/parser-input-select.min.js';
            // define column 3 as sortable of type input
            $tablesorter_parameters .= "headers: {
                2: {sorter: 'inputs'},
            }";
            $class_to_remove = 'table-condensed table-striped';
            $compact_table = true;
            break;
        default:
            return;
    }
    $scriptList_js = json_encode($scriptList); // convert php array to js array
    ?>
    <script title="tablesorter_loader">
        <?php if ($debug_tsl) { ?>
        console.group('tablesorter_loader:<?= $current_page; ?>');
        <?php } ?>
        let scriptList = <?= $scriptList_js; ?>;
        <?php if ($debug_tsl) { ?>
        console.debug('scriptList:' + JSON.stringify(scriptList));
        <?php } ?>
        scriptList.forEach(function (a) {  //loop to create a script link for each script file
            let script = document.createElement('script');
            script.src = a;
            script.async = true;
            $('head').append(script); // note: if appended to end of document, the subsequent function calls fail
        });

        //note: use of functions needs to be after page load
        window.onload = function () {
            //add css in head, below last css link
            $('head link[rel="stylesheet"]').last().after('<link rel="stylesheet" href="<?= $tablesorter_path . $tablesorter_theme; ?>" media="screen">');
            //add tablesorter class to table
            $('<?= $table_selector; ?>').addClass("tablesorter");
            //remove unecessary core classes from banner table
            $('<?= $table_selector; ?>').removeClass('<?= $class_to_remove; ?>');
            //reduce width to minimum, default tablesorter css is 100%
            <?php if ($compact_table) { ?>
            $('table.tablesorter').css("width", "auto");
            <?php } ?>
            $(function () {
                $('<?= $table_selector; ?>').tablesorter({
                    <?= $tablesorter_parameters; ?>
                });
            });
        };
        <?php if ($debug_tsl) { ?>
        console.groupEnd();
        <?php } ?>
    </script>
    <?php
}
