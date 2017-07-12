<?php

/*
 *  Create a base animal class that contains a serial number property
    Create the following child classes “goat” and “sheep”
    Generate 100 unique and random prime numbers from 0 to 10,000.
    Attribute each "serial" prime number to a baby goat, and store in file goat.txt.
    Generate serial numbers using the same method for sheep, and save in sheep.txt.
    Find all instances where the serial numbers assigned to goat and sheep are equal and save these serials to a new file called soulmates.txt.
    Output to screen: interesting facts about each set of serial numbers generated (ie. average sum, mean, etc. get creative)

 *
 */

class Animal
{
    private $serialNum;
    public static $counter = 0;

    function __construct() {
        $this->serialNum = $this->setSerialNum() ;
        self::$counter++;
    }

    /**
     * @return mixed
     */
    public function getSerialNum()
    {
        return $this->serialNum;
    }

    /**
     * @param mixed $serialNum
     */
    public function setSerialNum()
    {
        $this->serialNum = array_rand($this->getHundredPrimeNumber(),1);

    }

    private function getHundredPrimeNumber(){
        $primeNum = $this->getPrimeNumber();
        $count = sizeof($primeNum);
        $hundredPrimeNum = Array();

        for ($j = 0; $j<$count; $j++){
            if ($j<100){
                array_push($hundredPrimeNum, $primeNum[$j]);
            }
        }
        return $hundredPrimeNum;
    }


    private function getPrimeNumber(){
        $range = 10000;
        $primeNumbers = array(1,2);

        for ($j = 1; $j<=$range; $j++){
            $prime = 1;
            $divRange = ceil(sqrt($j));

            for ($i = 2; $i<=$divRange; $i++){
                if( ($j % $i != 0) && ($i != $j)  ) {
                    $prime = $prime * 1;
                }else{
                    $prime = $prime * 0;
                }
            }
            $prime == 1? array_push($primeNumbers, $j):"";

        } return array_values(array_unique($primeNumbers));

    }



}

class Goat extends Animal {
    function __construct() {
        parent::__construct();
        parent::setSerialNum();

    }
    function save(){
        file_put_contents("goat.txt", serialize($this)."*Saved*", FILE_APPEND);
    }
}


class Sheep extends Animal
{
    function __construct(){
        parent::__construct();
        parent::setSerialNum();
    }

    function save(){
        file_put_contents("sheep.txt", serialize($this)."*Saved*",FILE_APPEND);
    }
}



function getObject_Data($filename){
    $Arr = Array();
    $data = file_get_contents($filename);
    $out = explode("*Saved*", $data);
    $count = count($out);

    for ($i = 0; $i < $count; $i++){
        $obj = unserialize($out[$i]);
        if ($obj) {
            echo strtoupper (explode(".",$filename)[0]) . " Serial No :" . $obj->getSerialNum();
            array_push($Arr, $obj->getSerialNum());
        } echo '<br/>';

    } return $Arr;
}


/**********************************************************/

$createdObject = array();

$A1 = new Goat();
echo "New Goat :" . $A1->getSerialNum();
echo "<br>";
$A1->save();

$A2 = new Goat();
echo "New Goat :" .  $A2->getSerialNum();
echo "<br>";
$A2->save();

$B1 = new Sheep();
echo "New Sheep :" .  $B1->getSerialNum();
echo "<br>";
$B1->save();

$B2 = new Sheep();
echo "New Sheep :" . $B2->getSerialNum();
echo "<br>";
$B2->save();

echo "Total Animal Created This Time: " .  Animal::$counter;
echo "<br>";

// Read files to get the member data.
$goatArr = getObject_Data('goat.txt');
$sheepArr = getObject_Data('sheep.txt');

// Check both the arrays  and see if any SN matches.
for ($i = 0; $i < sizeof($goatArr); $i++){
    for ($j = 0; $j < sizeof($sheepArr); $j++){
        // if matches then save the serial
        $goatArr[$i] == $sheepArr[$j] ? file_put_contents("soulmates.txt", $goatArr[$i]."***", FILE_APPEND) : "";
    }
}









?>