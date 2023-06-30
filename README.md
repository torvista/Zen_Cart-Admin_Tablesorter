# Zen Cart - Admin Tablesorter
Add column sorting to an admin table using jquery tablesorter.  
Note this will only sort the table as shown on the page, not an entire multi-page results set.

## Installation
1. Download jquery tablesorter from https://github.com/Mottie/tablesorter
1. Copy only the /dist folder to
ADMIN_FOLDER/includes/javascript/tablesorter/dist
1. Copy the three files from this package to
ADMIN_FOLDER/includes/javascript/tablesorter/tablesorter_loader.php
ADMIN_FOLDER/includes/javascript/banner_manager_tablesorter.php (example file)
ADMIN_FOLDER/includes/javascript/option_values_tablesorter.php (example file)

These will add tablesorting to those pages.

### Adding to other admin pages
1. Copy and rename one of the example files to use the name of the admin page.
1. Optionally add a case for the admin page in the switch in tablesorter_loader.php using one of the existing cases as an example, if you need additional scripts or need to change the formatting.

## Changelog
30/06/2023 torvista: initial commit