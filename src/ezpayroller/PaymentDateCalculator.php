<?php
namespace ezpayroller;

use \Carbon\Carbon;

/**
 * Calculator that can tell what dates certain payments should be made upon
 */
class PaymentDateCalculator
{
    /**
     * @param int $year 4 digit year, E.g. 2013
     * @param int $month From 1-12, E.g. 2
     *
     * @return type E.g. February
     */
    public function getMonthName($month)
    {
        // Create a date from no particular year and return its month name
        $date = Carbon::createFromDate(2000, $month, 1);
        return $date->format('F');
    }

    /**
     * @param int $year 4 digit year, E.g. 2013
     * @param int $month From 1-12, E.g. 2
     *
     * @return \Carbon\Carbon The date that the month starting on
     * the first of $month in $year is paid on. Either the last day
     * of the month, or the Friday before.
     */
    public function getSalaryPaymentDate($year, $month)
    {
        $date = Carbon::createFromDate($year, $month, 1);
        /* @var $paymentDate \Carbon\Carbon */
        $paymentDate = $date->modify('last day of this month');
        while ($paymentDate->isWeekend()) {
            $paymentDate = $paymentDate->subDay();
        }
        return $paymentDate;
    }

    /**
     * @param int $year 4 digit year, E.g. 2013
     * @param int $month From 1-12, E.g. 2
     *
     * @return \Carbon\Carbon The date that the month starting on
     * the first of $month in $year has bonuses paid for. Either the
     * 15th, unless that is a weekend, in which case the subsequent
     * Wednesday.
     */
    public function getBonusPaymentDate($year, $month)
    {
        /* @var $date \Carbon\Carbon */
        $date = Carbon::createFromDate($year, $month, 15);
        if ($date->isWeekend()) {
            while ($date->dayOfWeek !== Carbon::WEDNESDAY) {
                $date = $date->addDay();
            }
        }
        return $date;
    }
}
