<?php 

/**
 * Given a set of items, each with a weight and a value,
 * determine the number of each item to include in a collection
 * so that the total weight is less than or equal to a given limit
 * and the total value is as large as possible.
*/

function KnapSack($capacity, $weight, $value, $itemsCount, &$steps=[])
{
	$K = [];

	for ($i = 0; $i <= $itemsCount; ++$i) // foreach item we have
	{
		for ($w = 0; $w <= $capacity; ++$w) // looping through possible capacity
		{
			
			// The first Row is always 0 
			if ($i == 0 || $w == 0) {
				$K[$i][$w] = 0;
			}

			else if ($weight[$i-1] <= $w){ // If the current items weight can fit inside the sack

				$maxValueWithoutCurrent = $K[$i-1][$w];
                $valueOfCurrentItem = $value[$i - 1];
				$weightOfCurrentItem = $weight[$i-1];

				$maxValueWithCurrent = $value[$i-1]; // Max value is at least the value of current item

				$remainingCapacity = $w - $weightOfCurrentItem; 
				// The max Value we can get with the remaining Capacity is stored at $K[$i-1][NUMBER_OF_CAPACITY_REMAINING]
				$maxValueWithCurrent += $K[$i-1][$remainingCapacity]; 


				$K[$i][$w]=@max($maxValueWithCurrent,$maxValueWithoutCurrent);

				// $K[$i][$w] = @max($value[$i - 1] + $K[$i - 1][$w - $weight[$i - 1]], $K[$i - 1][$w]);
			}else {
				$K[$i][$w] = $K[$i - 1][$w]; // else put the previous capacity
			}
	
		}
	}
	$steps = $K;
	return $K[$itemsCount][$capacity];
}

function printKnapSackItems($capacity,$weight,$value,$itemsCount,$finalResultArray) {
	$itemsIncluded = [];
	$result = $finalResultArray[$itemsCount][$capacity]; // The max value we can get in stored in the last element of the result array
	for ($i=$itemsCount; $i>0 && $result > 0; $i--) {
		// If they are the same it means that we didnt include the item
		// From the KnapSack Function we either add the $maxValueWithCurrent or $maxValueWithoutCurrent = $K[$i-1][$currentCapacity]
		if($result == $finalResultArray[$i-1][$capacity]) {
			continue;
		}else {
			// The item is Included
			array_push($itemsIncluded, $weight[$i-1]); // The index of the item included is the $i-1;
			$result = $result - $value[$i-1]; // and we remove the value of the current Item;

		}
	}
	return $itemsIncluded;
}

$value = [10, 40,  30, 50];
$weight = [5, 4, 6, 3];
$capacity = 10;
$itemsCount = 4;
$steps = [];

$result = KnapSack($capacity, $weight, $value, $itemsCount, $steps);
$itemsIncluded = printKnapSackItems($capacity, $weight, $value, $itemsCount, $steps);

var_dump($result);
var_dump($itemsIncluded);
print_r($steps);
