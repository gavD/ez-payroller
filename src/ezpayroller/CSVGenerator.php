<?php
namespace ezpayroller;

/**
 * Generates a CSV that looks something like:
 *
 * <code>
 * Month name,Salary payment date,Bonus payment date
 * January,Monday 31st,Wednesday 19th
 * February,Monday 28th,Tuesday 15th
 * March,Thursday 31st,Tuesday 15th
 * April,Friday 29th,Friday 15th
 * May,Tuesday 31st,Wednesday 18th
 * June,Thursday 30th,Wednesday 15th
 * July,Friday 29th,Friday 15th
 * August,Wednesday 31st,Monday 15th
 * September,Friday 30th,Thursday 15th
 * October,Monday 31st,Wednesday 19th
 * November,Wednesday 30th,Tuesday 15th
 * December,Friday 30th,Thursday 15th
 * </code>
 */
class CSVGenerator
{
    /**
     * @var PayrollCollator Used to pull together the payroll for a given year.
     */
    private $payroll;

    /**
     * Format for the salary payment and bonus payment dates
     */
    const DATE_FORMAT = 'l jS';

    /**
     * IOC pattern (dependency injection)
     * @param \ezpayroller\PayrollCollator $payroll
     */
    public function __construct(PayrollCollator $payroll)
    {
        $this->payroll = $payroll;
    }

    /**
     * Display a year to STDOUT.
     *
     * @param int $year E.g. 2013
     *
     * @codeCoverageIgnore
     */
    public function displayYear($year)
    {
        echo $this->generateCSV((int)$year);
    }

    /**
     * Generate a CSV for a given year. Use this if you want to get the CSV
     * as a string rather than dump it to STDOUT.
     *
     * @param int $year E.g. 2013
     * @return string CSV. Dates are formatted 'l jS'
     */
    public function generateCSV($year) {

        $payroll = $this->payroll->getPayroll((int)$year);

        // As this is a small data set, string concatenation is adequate and
        // performant.
        $csv = "Month name,Salary payment date,Bonus payment date\n";
        foreach($payroll as $month) {
            $csv .= $month['Month name'];
            $csv .= ',' . $month['Salary payment date']->format(self::DATE_FORMAT);
            $csv .= ',' . $month['Bonus payment date']->format(self::DATE_FORMAT);
            $csv .= "\n";
        }

        return $csv;
    }
}