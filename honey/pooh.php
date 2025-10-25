<?php
// Pooh Honeypot v2
// Creates recursive temp directories in-place (not in parent)

// Function to create subdirectories in the *current* directory
function createSubdirectories($path) {
    for ($i = 1; $i <= 3; $i++) {
        $uniqueDirName = uniqid('php_temp_dir_');
        $subDir = $path . '/' . $uniqueDirName . $i;

        if (!file_exists($subDir)) {
            mkdir($subDir, 0755, true);
            chmod($subDir, 0755);

            // Create recursive index.php
            $indexContent = <<<PHP
<?php
// Auto-generated subdirectory
include __DIR__ . "/../pooh.php";
?>
PHP;
            file_put_contents($subDir . '/index.php', $indexContent);
            chmod($subDir . '/index.php', 0655);
        }
    }
}

// Function to log visitor access
function logAccess($path) {
    $logFile = __DIR__ . '/access.log';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $time = date('Y-m-d H:i:s');
    $entry = "$time - $ip - $path\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
}

// --- MAIN EXECUTION ---

// Detect the directory of the *executing script*, not the include
$currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

// Log access
logAccess($currentDir);

// Create subdirectories *in the current directory*
createSubdirectories($currentDir);

// Output
echo "<h3>Yo dawg, I heard you like directories...</h3>";
echo "<p>So I put directories in your directories,<br>
so you can direct your directors while you direct your directions.</p>";

// List the new subdirectories
$dirs = glob($currentDir . '/php_temp_dir_*', GLOB_ONLYDIR);
foreach ($dirs as $dir) {
    $basename = basename($dir);
    echo "<a href='./$basename/'>$basename</a><br>";
}
?>
