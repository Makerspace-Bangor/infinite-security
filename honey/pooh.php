<?php
// its a honey pot Pooh! or:
//Yo dawg, I heard you like directories, so I put directories in your directories, so you can direct your directors while you direct your directions. 

// Function to create subdirectories
function createSubdirectories($path) {
    for ($i = 1; $i <= 3; $i++) {
        $subDir = $path . '/subdir' . $i;
        if (!file_exists($subDir)) {
            mkdir($subDir, 0755, true);
            file_put_contents($subDir . '/index.php', '<?php include "../pooh.php"; ?>');
        }
    }
}

// Function to log access
function logAccess($path) {
    $logFile = 'access.log';
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date('Y-m-d H:i:s');
    $entry = "$time - $ip - $path\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
    
}

// Get the current directory
$currentDir = dirname(__FILE__);

// Log access
logAccess($currentDir);

// Create subdirectories
createSubdirectories($currentDir);

// optional: Display a message 
echo "Yo dawg, I heard you like directories,<br>
so I put directories in your directories, <br>
so you can direct your directors while you direct your directions. ";
?>
