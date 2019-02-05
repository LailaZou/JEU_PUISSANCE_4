<?php
require '../controleur/gagnerClass.php';
use PHPUnit\Framework\TestCase;
 
class gagnerTests extends TestCase
{
    private $class;
 
    protected function setUp()
    {
        $this->class = new gagner();
    }
 
    protected function tearDown()
    {
        $this->class = NULL;
    }

    /**
     * @dataProvider boardforexcpected
     */
    public function testAdd($board , $col, $excpected)
    {
            $_SESSION['board'] = $board;
            $_SESSION['turn'] = 1;

        $result = $this->class->est_gagnant($col);
        $this->assertEquals($excpected, $result);
    }

    public function boardforexcpected()
    {
        //Avec ces exemples on presque tester tous les cas ou la machine doit prendre une decision bien specifique
        return [
         //vertical
        [array(
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(1, 1, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(1, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),4,true],
        [array(
         //vertical
            array(0, 0, 0, 0, 0, 0),
            array(2, 2, 0, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(2, 2, 0, 0, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),4,false],
        [array(
         //horizontal
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(1, 1, 1, 1, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),3,true],
        [array(
         //horizontal
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(2, 2, 2, 2, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),3,false],
        [array(
         //diagonal
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(1, 2, 1, 0, 0, 0),
            array(2, 2, 1, 1, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),4,true],
        [array(
         //horizontal
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(1, 1, 1, 1, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),3,true],
        [array(
            array(0, 0, 0, 0, 0, 0),
            array(1, 2, 0, 0, 0, 0),
            array(2, 2, 0, 0, 0, 0),
            array(1, 1, 2, 0, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),3,false],
        [array(
            array(2, 2, 1, 1, 0, 0),
            array(1, 2, 1, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(1, 1, 1, 1, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),0,true],
        [array(
            array(2, 2, 1, 1, 0, 0),
            array(1, 2, 1, 0, 0, 0),
            array(2, 1, 0, 0, 0, 0),
            array(1, 1, 1, 1, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),1,true],
        [array(
            array(2, 2, 1, 1, 0, 0),
            array(1, 2, 1, 0, 0, 0),
            array(2, 0, 0, 0, 0, 0),
            array(1, 1, 0, 0, 0, 0),
            array(1, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0)
            ),0,false]
        ];
    }
 
}
