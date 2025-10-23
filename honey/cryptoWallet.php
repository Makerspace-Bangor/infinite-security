<?php
// A bitcoin wallet that never finishes downloading.
// Set the headers to force download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="My_Crypto_Wallet.txt"');

// Open /dev/random for reading
$randomFile = fopen('/dev/random', 'rb');
if ($randomFile === false) {
    die('Unable to open /dev/random');
}

// Continuously read and output chunks of random data
while (true) {
    // Read a chunk of 1024 bytes from /dev/random
    $data = fread($randomFile, 1024);
    if ($data === false) {
        break;
    }
    echo $data;
    flush();
    usleep(1000);
}

// Close the file handle
fclose($randomFile);
?>
