<?php
namespace ezpayroller;

class CSVGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CSVGenerator
     */
    private $sut;

    public function setUp() {
        parent::setUp();

        $paymentCollator = new PayrollCollator(new PaymentDateCalculator());
        $this->sut = new CSVGenerator($paymentCollator);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\ezpayroller\CSVGenerator', $this->sut);
    }

    public function testPayrollForAYearPullsTogether12Months()
    {
        $expected = <<<EOF
Month name,Salary payment date,Bonus payment date
January,Friday 29th,Friday 15th
February,Friday 26th,Monday 15th
March,Wednesday 31st,Monday 15th
April,Friday 30th,Thursday 15th
May,Monday 31st,Wednesday 19th
June,Wednesday 30th,Tuesday 15th
July,Friday 30th,Thursday 15th
August,Tuesday 31st,Wednesday 18th
September,Thursday 30th,Wednesday 15th
October,Friday 29th,Friday 15th
November,Tuesday 30th,Monday 15th
December,Friday 31st,Wednesday 15th

EOF;

        $csv = $this->sut->generateCSV(2010);
        $this->assertEquals($expected, $csv);
    }
}