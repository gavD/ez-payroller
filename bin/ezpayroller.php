#!/usr/local/bin/php
<?php
/**
 * Launcher for the tool
 */
namespace ezpayroller;

include 'src/bootstrap.php';

if ($argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

EZ Payroller - CLI utility to generate payroll CSV

  Usage:
  <?php echo $argv[0]; ?> <year>

  <year> The year you would like to dump out.

  With the --help, -help, -h, or -? options, you can get this help.

<?php
} else {
    if(!is_numeric($argv[1]) || strlen($argv[1]) !== 4) {
        die("Year must be numeric, e.g. 2013");
    }

    $year = (int) $argv[1];

    $paymentCollator = new PayrollCollator(new PaymentDateCalculator());
    $gen = new CSVGenerator($paymentCollator);
    $gen->displayYear($year);
}

