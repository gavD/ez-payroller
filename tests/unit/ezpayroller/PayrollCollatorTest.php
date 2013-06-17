<?php
namespace ezpayroller;

use \Carbon\Carbon;

class PayrollCollatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PayrollCollator
     */
    private $sut;

    public function setUp() {
        parent::setUp();

        $this->sut = new PayrollCollator(new PaymentDateCalculator);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\ezpayroller\PayrollCollator', $this->sut);
    }

    public function testPayrollGenerates12MonthsOfData()
    {
        $payroll = $this->sut->getPayroll(2012);
        $this->assertEquals(12, count($payroll));
        $this->assertEquals(31, $payroll[0][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(29, $payroll[1][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(30, $payroll[2][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(30, $payroll[3][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(31, $payroll[4][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(29, $payroll[5][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(31, $payroll[6][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(31, $payroll[7][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(28, $payroll[8][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(31, $payroll[9][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(30, $payroll[10][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);
        $this->assertEquals(31, $payroll[11][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->day);

        // check days of week are correct
        $this->assertEquals(Carbon::TUESDAY, $payroll[0][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::WEDNESDAY, $payroll[1][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::FRIDAY, $payroll[2][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::MONDAY, $payroll[3][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::THURSDAY, $payroll[4][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::FRIDAY, $payroll[5][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::TUESDAY, $payroll[6][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::FRIDAY, $payroll[7][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::FRIDAY, $payroll[8][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::WEDNESDAY, $payroll[9][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::FRIDAY, $payroll[10][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
        $this->assertEquals(Carbon::MONDAY, $payroll[11][PayrollCollator::FIELD_SALARY_PAYMENT_DATE]->dayOfWeek);
    }
}