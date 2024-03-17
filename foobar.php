<?php
// foobar.php

// Loop through numbers from 1 to 100
for ($i = 1; $i <= 100; $i++) {
    // Check if the current number is divisible by both 3 and 5
    if ($i % 3 === 0 && $i % 5 === 0) {
        echo "foobar"; // If so, output "foobar"
    } 
    // Check if the current number is divisible by 3
    elseif ($i % 3 === 0) {
        echo "foo"; // If so, output "foo"
    } 
    // Check if the current number is divisible by 5
    elseif ($i % 5 === 0) {
        echo "bar"; // If so, output "bar"
    } 
    // If the current number is not divisible by either 3 or 5
    else {
        echo $i; // Output the current number
    }

    // Add a comma after the output, unless it's the last number
    if ($i < 100) {
        echo ", ";
    }
}

// Add a new line after the loop completes
echo "\n";
?>
