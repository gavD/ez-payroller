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

    const FIELD_MONTH_NAME = 'Month name';
    const FIELD_SALARY_PAYMENT_DATE = 'Salary payment date';
    const FIELD_BONUS_PAYMENT_DATE = 'Bonus payment date';

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
                self::FIELD_MONTH_NAME => $this->dateCalc->getMonthName($month),
                self::FIELD_SALARY_PAYMENT_DATE => $this->dateCalc->getSalaryPaymentDate($year, $month),
                self::FIELD_BONUS_PAYMENT_DATE => $this->dateCalc->getBonusPaymentDate($year, $month)
            );
        }
        return $response;
    }
}
