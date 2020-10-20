// If reversing negative
// Are we working with both integers and floats?
function reverseBinary(num) {
    var binary_representation = (num).toString(2);

    // Reverse Binary then cast to Int
    var reversed = binary_representation.split('').reverse().join('');
    var reversed_int = parseInt(reversed, 2);

    // Lets deal with the negative numbers
    if(num < 0) {
        return reversed_int * -1;
    }

    return reversed_int;

}
