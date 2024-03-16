<?php


// Command line arguments options
$options = getopt("u:p:h:", ["file:", "create_table", "dry_run", "help", "database:"]);

// If help option is provided 
if (isset($options['help'])) {
    echo "Usage: php user_upload.php [options]\n";
    echo "Options:\n";
    echo "  --file [csv file name]   The name of the CSV to be parsed\n";
    echo "  --create_table           Create the MySQL users table (and no further action will be taken)\n";
    echo "  --dry_run                Execute script without altering the database\n";
    echo "  -u                       MySQL username\n";
    echo "  -p                       MySQL password\n";
    echo "  -h                       MySQL host\n";
    echo "  --database               MySQL database name\n";
    exit;
}


?>
