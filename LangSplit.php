<?php
// Function to process each line of the input file
function processLine($line) {
    // Split the line into columns
    $columns = explode("\t", $line);
    // Extract data from columns
    $schoolId = $columns[0];
    $studentId = $columns[1];
    $guardians = explode('|', $columns[2]);
    // Process each guardian
    $output = [];
    foreach ($guardians as $guardian) {
        // Split guardian ID and language (if present)
        $guardianData = explode(',', $guardian);
        $guardianId = 'CON' . trim($guardianData[0]); // Ensure 'CON' prefix and trim whitespace
        // Extract language (if present)
        $language = isset($guardianData[1]) ? trim($guardianData[1]) : '';
        // Add data to output array
        $output[] = [$schoolId, $studentId, $guardianId, $language];
    }
    return $output;
}
// Input and output file paths
$inputFile = '/opt/sftpgroup/xxxxx/home/xxxxx/guardianlanguage.txt';
$outputFile = 'data/language.csv';
// Open input file for reading
$inputHandle = fopen($inputFile, 'r');
// Open output file for writing
$outputHandle = fopen($outputFile, 'w');
// Process each line of the input file
while (!feof($inputHandle)) {
    $line = fgets($inputHandle);
    // Skip empty lines
    if (trim($line) == '') {
        continue;
    }
    // Process line
    $outputData = processLine($line);
    // Write output data to output file
    foreach ($outputData as $data) {
        fputcsv($outputHandle, $data);
    }
}
// Close file handles
fclose($inputHandle);
fclose($outputHandle);
echo "Output written to $outputFile\n";
?>
