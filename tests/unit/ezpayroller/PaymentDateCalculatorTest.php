<?php
namespace ezpayroller;

use \Carbon\Carbon;

/**
 * It is unreliastic to verify that the calculator works in every possible
 * date, but doubt can be managed by testing as many edge cases as possible
 */
class PaymentDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentDateCalculator
     */
    private $sut;

    public function setUp() {
        parent::setUp();

        $this->sut = new PaymentDateCalculator();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\ezpayroller\PaymentDateCalculator', $this->sut);
    }

    public function testMonthlySalaryDefaultsToLastDayOfMonth()
    {
        // Jan 2012
        //              January
        //Su Mo Tu We Th Fr Sa
        // 1  2  3  4  5  6  7
        // 8  9 10 11 12 13 14
        //15 16 17 18 19 20 21
        //22 23 24 25 26 27 28
        //29 30 31

        $this->assertEquals(31, $this->sut->getSalaryPaymentDate(2012, 1)->day);
        $this->assertEquals(Carbon::TUESDAY, $this->sut->getSalaryPaymentDate(2012, 1)->dayOfWeek);

        // Feb 2012
        //              February
        //Su Mo Tu We Th Fr Sa
        //          1  2  3  4
        // 5  6  7  8  9 10 11
        //12 13 14 15 16 17 18
        //19 20 21 22 23 24 25
        //26 27 28 29
        $this->assertEquals(29, $this->sut->getSalaryPaymentDate(2012, 2)->day);
        $this->assertEquals(Carbon::WEDNESDAY, $this->sut->getSalaryPaymentDate(2012, 2)->dayOfWeek);

        // December 2012
        //              December
        //Su Mo Tu We Th Fr Sa
        //                   1
        // 2  3  4  5  6  7  8
        // 9 10 11 12 13 14 15
        //16 17 18 19 20 21 22
        //23 24 25 26 27 28 29
        //30 31
        $this->assertEquals(31, $this->sut->getSalaryPaymentDate(2012, 12)->day);
        $this->assertEquals(Carbon::MONDAY, $this->sut->getSalaryPaymentDate(2012, 12)->dayOfWeek);
    }

    public function testMonthlySalaryGoesOutOnLastFridayOfTheMonthIfTheMonthEndsOnSaturday() {
        // March 2012
        //         March
        //Su Mo Tu We Th Fr Sa
        //             1  2  3
        // 4  5  6  7  8  9 10
        //11 12 13 14 15 16 17
        //18 19 20 21 22 23 24
        //25 26 27 28 29 30 31

        $this->assertEquals(30, $this->sut->getSalaryPaymentDate(2012, 3)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(2012, 3)->dayOfWeek);
    }


    public function testMonthlySalaryGoesOutOnLastFridayOfTheMonthIfTheMonthEndsOnSunday() {
        // September 2012
        //      September
        //Su Mo Tu We Th Fr Sa
        //                   1
        // 2  3  4  5  6  7  8
        // 9 10 11 12 13 14 15
        //16 17 18 19 20 21 22
        //23 24 25 26 27 28 29
        //30

        $this->assertEquals(28, $this->sut->getSalaryPaymentDate(2012, 9)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(2012, 9)->dayOfWeek);
    }

    public function testRulesAreStillGoodBeforeTheUnixEpoch()
    {
        // Nov 1965 ends on Tuesday 30th
        $this->assertEquals(30, $this->sut->getSalaryPaymentDate(1965, 11)->day);
        $this->assertEquals(Carbon::TUESDAY, $this->sut->getSalaryPaymentDate(1965, 11)->dayOfWeek);

        // July 1965 ends on Saturday 31st
        $this->assertEquals(30, $this->sut->getSalaryPaymentDate(1965, 7)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(1965, 7)->dayOfWeek);

        // Jan 1965 ends on Sunday 31st
        $this->assertEquals(29, $this->sut->getSalaryPaymentDate(1965, 1)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(1965, 1)->dayOfWeek);
    }

    public function testRulesAreStillGoodAfterTheUnixEpoch()
    {
        // (as per an unsigned integer representing a unix datestamp)
        //
        // May 2050 ends on Tuesday 31st
        $this->assertEquals(31, $this->sut->getSalaryPaymentDate(2050, 5)->day);
        $this->assertEquals(Carbon::TUESDAY, $this->sut->getSalaryPaymentDate(2050, 5)->dayOfWeek);

        // Sep 2050 ends on Friday 30th
        $this->assertEquals(30, $this->sut->getSalaryPaymentDate(2050, 9)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(2050, 9)->dayOfWeek);

        // Dec 2050 ends on Saturday 31st
        $this->assertEquals(30, $this->sut->getSalaryPaymentDate(2050, 12)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(2050, 12)->dayOfWeek);

        // April 2051 ends on Sunday 30th
        $this->assertEquals(28, $this->sut->getSalaryPaymentDate(2051, 4)->day);
        $this->assertEquals(Carbon::FRIDAY, $this->sut->getSalaryPaymentDate(2051, 4)->dayOfWeek);
    }





    // Tests for bonus payments

    public function testBonusPaymentDefaultsToFifteenthOfMonth()
    {
        // Feb 2012
        //              February
        //Su Mo Tu We Th Fr Sa
        //          1  2  3  4
        // 5  6  7  8  9 10 11
        //12 13 14 15 16 17 18
        //19 20 21 22 23 24 25
        //26 27 28 29
        $this->assertEquals(15, $this->sut->getBonusPaymentDate(2012, 2)->day);
        $this->assertEquals(Carbon::WEDNESDAY, $this->sut->getBonusPaymentDate(2012, 2)->dayOfWeek);
    }

    public function testBonusPaymentAreOnTheNextWednesdayAfterTheFifteenthShouldTheFifteenthFallOnAWeekend()
    {
            // Jan 2012
        //              January
        //Su Mo Tu We Th Fr Sa
        // 1  2  3  4  5  6  7
        // 8  9 10 11 12 13 14
        //15 16 17 18 19 20 21
        //22 23 24 25 26 27 28
        //29 30 31

        $this->assertEquals(18, $this->sut->getBonusPaymentDate(2012, 1)->day);
        $this->assertEquals(Carbon::WEDNESDAY, $this->sut->getBonusPaymentDate(2012, 1)->dayOfWeek);

        // December 2012
        //              December
        //Su Mo Tu We Th Fr Sa
        //                   1
        // 2  3  4  5  6  7  8
        // 9 10 11 12 13 14 15
        //16 17 18 19 20 21 22
        //23 24 25 26 27 28 29
        //30 31
        $this->assertEquals(19, $this->sut->getBonusPaymentDate(2012, 12)->day);
        $this->assertEquals(Carbon::WEDNESDAY, $this->sut->getBonusPaymentDate(2012, 12)->dayOfWeek);
    }
}