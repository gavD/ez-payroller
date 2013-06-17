<?php
namespace ezpayroller;

/**
 * Tool that can go through a given year's month and add calculations of the
 * salary payment dates.
 */
class PayrollCollator
{
    /**
     * @var \ezpayroller\PaymentDateCalculator $dateCalc Used for calculating dates
     */
    private $dateCalc;

    /**
     * IOC pattern (dependency injection)
     * @param \ezpayroller\PaymentDateCalculator $dateCalc Used for calculating
     * the payment dates for each month.
     */
    public function __construct(PaymentDateCalculator $dateCalc)
    {
        $this->dateCalc = $dateCalc;
    }

    /**
     * @param int $year E.g. 2004
     *
     * @return array Array of results with keys:
     *  - Month name
     *  - Salary payment date
     *  - Bonus payment date
     */
    public function getPayroll($year)
    {
        $response = array();

        for ($month = 1; $month <= 12; $month++) {
            $response[] = array(
                'Month name' => $this->dateCalc->getMonthName($month),
                'Salary payment date' => $this->dateCalc->getSalaryPaymentDate($year, $month),
                'Bonus payment date' => $this->dateCalc->getBonusPaymentDate($year, $month)
            );
        }
        return $response;
    }
}
