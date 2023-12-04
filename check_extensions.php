<?php
echo "Installed PHP Extensions:\n";
foreach (get_loaded_extensions() as $extension) {
    echo $extension . "\n";
}

echo "\n\nCheck Specific Installed PHP Extensions:\n";
$extensions = ['zip', 'xml', 'gd', 'iconv', 'simplexml', 'xmlreader', 'zlib'];

foreach ($extensions as $extension) {
    echo "$extension: " . (extension_loaded($extension) ? 'enabled' : 'disabled') . "\n";
}

// In bash run this: php check_extensions.php