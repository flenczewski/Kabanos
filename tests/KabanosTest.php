<?php
/**
 * Created by PhpStorm.
 * User: fabian
 * Date: 2014-07-17
 * Time: 00:33
 */

class KabanosTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Kabanos
     */
    protected $kabanos;

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Kabanos'));
    }

    public function setUp()
    {
        $this->kabanos = new Kabanos;
    }

    public function providerData()
    {
        return array(
            array('phpunit#1', 10, 5, 123),
            array('phpunit#2', 60, 10, 123),
            array('phpunit#3', 120, 15, 123)
        );
    }

    /**
     * @dataProvider providerData
     */
    public function testCheck($type, $second, $limit, $userId)
    {
        // it ok
        for($a = 0; $a < $limit; $a++) {
            $res = $this->kabanos->check($type, array($second => $limit), $userId);
        }
        $this->assertFalse( $res );

        // banned
        $res = $this->kabanos->check($type, array($second => $limit), $userId);
        $this->assertArrayHasKey($second, $res);

        // cleaning data
        $this->kabanos->removeBan($type, $second, $userId);
    }

    /**
     * @dataProvider providerData
     */
    public function testCheckBan($type, $second, $limit, $userId)
    {
        // banned
        for($a = 0; $a < $limit+1; $a++) {
            $res = $this->kabanos->check($type, array($second => $limit), $userId);
        }
        $this->assertArrayHasKey($second, $res);

        // cleaning data
        $this->kabanos->removeBan($type, $second, $userId);
    }
}
 