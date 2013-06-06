<?php
namespace ezpayroller;

class CSVGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeCreated()
    {
        $csvGen = new CSVGenerator();
        $this->assertInstanceOf('\ezpayroller\CSVGenerator', $csvGen);
    }
}