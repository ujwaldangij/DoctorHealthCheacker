<?php

$n = [5, 2, 8, 1, 3, 7, 4, 6];
$count = count($n);
$m = 0;
//8,7,6,5,4,3,2,1
echo "<pre>";
print_r($n);

//bubble short

for ($i=0; $i < $count -1 ; $i++) {
    // echo "working on pass no ".$i+1;
    for ($j=0; $j < $count -1 - $i ; $j++) {
        if ($n[$j] > $n[$j+1]) {
            $temp = $n[$j];
            $n[$j] = $n[$j +1];
            $n[$j +1] = $temp;
        }
    }
}
// echo "<pre>";
// print_r($n);

?>
