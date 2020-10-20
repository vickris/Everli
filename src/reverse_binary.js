function reverseBinary(num) {
    // Handle bad Input
    if(isNaN(num)) {
        throw "This function expects a number to be passed as the parameter"
    }

    // Using Number to cast String inputs to number format
    var binary_representation = (Number(num)).toString(2)

    // Reverse Binary then cast to number
    var reversed = binary_representation.split('').reverse().join('');
    var reversed_int = parseInt(reversed, 2)

    // Lets deal with the negative numbers
    if(num < 0) {
        return reversed_int * -1;
    }

    return reversed_int;
}
