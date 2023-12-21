<?php

declare(strict_types = 1);

// Your Code

function read_files(string $t_dir): array{
    $files_paths = [];
    foreach(scandir($t_dir) as $name){
        if(!is_dir($name)){
            $files_paths[] = $t_dir . $name;
        }
    }
    return $files_paths;
}

function parsed_files(array $files): array{
    $p_files = [];
    foreach($files as $file){
        
        $file_name = get_file_name($file);
        
        $csvFile = fopen($file, 'r');

        if ($csvFile !== false) {
            fgetcsv($csvFile);
            while (($data = fgetcsv($csvFile)) !== false) {
                $p_files[$file_name][] = row_handler($data);
            }
            fclose($csvFile);
            
        } else {
            echo "Error opening the CSV file.";
        }
    }

    return $p_files;
}

function get_file_name(string $path): string{ return pathinfo($path)['filename'];}

function row_handler(array $row): array{
    $row[3] = (float) str_replace(['$', ','], '', $row[3]);
    return [
        'date'        => $row[0],
        'checkNumber' => $row[1],
        'description' => $row[2],
        'amount'      => $row[3],
    ];
}

function formatDollarAmount(float $amount): string{ 
    return (($amount < 0) ? '-' : '') . '$' . number_format(abs($amount), 2);
}

function formatDate(string $date): string
{
    return date('M j, Y', strtotime($date));
}

function calculateTotals(array $transaction_files): array
{
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

    foreach ($transaction_files as $transactions) {
        foreach ($transactions as $transaction){
            $totals['netTotal'] += $transaction['amount'];

            if ($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }
    }

    return $totals;
}