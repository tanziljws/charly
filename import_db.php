<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$sqlFile = __DIR__.'/../laravelgaleri.sql';

if (!file_exists($sqlFile)) {
    echo "SQL file not found: $sqlFile\n";
    exit(1);
}

echo "Reading SQL file...\n";
$sql = file_get_contents($sqlFile);

// Remove SET statements that might cause issues
$sql = preg_replace('/SET SQL_MODE[^;]*;/i', '', $sql);
$sql = preg_replace('/START TRANSACTION;/i', '', $sql);
$sql = preg_replace('/COMMIT;/i', '', $sql);
$sql = preg_replace('/\/\*[^*]*\*+(?:\/[^*]*\*+)*\//', '', $sql);

// Split by semicolon but be careful with data
$statements = [];
$current = '';
$inQuotes = false;
$quoteChar = null;

for ($i = 0; $i < strlen($sql); $i++) {
    $char = $sql[$i];
    $current .= $char;
    
    if (($char === '"' || $char === "'") && ($i === 0 || $sql[$i-1] !== '\\')) {
        if (!$inQuotes) {
            $inQuotes = true;
            $quoteChar = $char;
        } elseif ($char === $quoteChar) {
            $inQuotes = false;
            $quoteChar = null;
        }
    }
    
    if (!$inQuotes && $char === ';') {
        $statement = trim($current);
        if (!empty($statement) && strlen($statement) > 10) {
            $statements[] = $statement;
        }
        $current = '';
    }
}

echo "Executing " . count($statements) . " statements...\n";

try {
    $success = 0;
    $errors = 0;
    $skipped = 0;
    
    foreach ($statements as $index => $statement) {
        try {
            // Skip CREATE TABLE if table exists, but allow INSERT
            if (preg_match('/CREATE TABLE/i', $statement)) {
                $tableName = '';
                if (preg_match('/CREATE TABLE\s+(?:IF NOT EXISTS\s+)?`?(\w+)`?/i', $statement, $matches)) {
                    $tableName = $matches[1];
                    if (DB::getSchemaBuilder()->hasTable($tableName)) {
                        $skipped++;
                        continue;
                    }
                }
            }
            
            DB::statement($statement);
            $success++;
            if (($index + 1) % 10 == 0) {
                echo "Processed " . ($index + 1) . " statements...\n";
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            // Skip duplicate key errors and table exists errors
            if (strpos($errorMsg, 'already exists') !== false || 
                strpos($errorMsg, 'Duplicate entry') !== false ||
                strpos($errorMsg, 'Base table or view already exists') !== false) {
                $skipped++;
                continue;
            }
            $errors++;
            // Only show first few real errors
            if ($errors <= 5) {
                echo "Error (statement " . ($index + 1) . "): " . substr($errorMsg, 0, 100) . "\n";
            }
        }
    }
    
    echo "\nImport completed!\n";
    echo "Success: $success statements\n";
    echo "Skipped (already exists): $skipped statements\n";
    echo "Errors: $errors statements\n";
    
} catch (\Exception $e) {
    echo "Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}

