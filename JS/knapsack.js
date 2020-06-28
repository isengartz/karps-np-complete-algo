const value = [10, 40,  30, 50];
const weight = [5, 4, 6, 3];
const capacity = 10;
const itemsCount = value.length;

const KnapSack = (capacity,weight,value,itemsCount) => {
	let K = [];
	const finalResult = {
		stepArray: [],
		maxValue: null
	}
// Initialize the array
	for (let g =0; g<=itemsCount; g++) {
		K[g] = [];
		for (let h =0; h <= capacity; h++) {
			K[g][h]=0;
		}
	}
	
	for (let i=0; i<= itemsCount;i++) {
	
		for (let w=0;w<=capacity;w++) {

			if (i===0 || w===0) {
				K[i][w]=0;
			}
			else if (weight[i-1]<=w) { // If current Items capacity can get in the sack
				
		
				let maxValueWithoutCurrent = K[i-1][w];
                let valueOfCurrentItem = value[i - 1];
				let weightOfCurrentItem = weight[i-1];
				let maxValueWithCurrent = value[i-1]; // Max value is at least the value of current item

				let remainingCapacity = w - weightOfCurrentItem; 
				// The max Value we can get with the remaining Capacity is stored at K[i-1][NUMBER_OF_CAPACITY_REMAINING]
				maxValueWithCurrent = maxValueWithCurrent + K[i-1][remainingCapacity]; 

				K[i][w]=Math.max(maxValueWithCurrent,maxValueWithoutCurrent);
			}else {
			
				K[i][w] = K[i - 1][w]; // else put the previous capacity
			}
		}
	}
	finalResult.stepArray=K;
	finalResult.maxValue = K[itemsCount][capacity];
	
	return finalResult;

	}


const printKnapSack = (capacity,weight,value,itemsCount,finalResultArray) => {
	const itemsIncluded = [];
	let result = finalResultArray[itemsCount][capacity]; // The max value we can get in stored in the last element of the result array
	for (let i=itemsCount; i>0 && result > 0; i--) {
		// If they are the same it means that we didnt include the item
		// From the KnapSack Function we either add the $maxValueWithCurrent or $maxValueWithoutCurrent = $K[$i-1][$currentCapacity]
		if(result == finalResultArray[i-1][capacity]) {
			continue;
		}else {
			// The item is Included
			itemsIncluded.push(weight[i-1]); // The index of the item included is the $i-1;
			$result = result - value[i-1]; // and we remove the value of the current Item;

		}
	}
	return itemsIncluded;
}

let result = KnapSack(capacity,weight,value,itemsCount);

let steps = printKnapSack(capacity,weight,value,itemsCount,result.steps);
console.debug(result);
console.debug(steps);