function getFaElementSize(elementId) {
    // fa icons' width (and height, they're always square elements)
    // is defined by font-size (for example 5em for fa-5x)
    // in order to know their true width
    // you first need to know how much is 1em 
    // and then know what its multiplicator is
    
    // first, you find font-size attribute's value
    // it will give you 1em size in pixel
    var resendNbIconWidth   = parseInt($(elementId).css("font-size").match(/[^px]/gm).join(""));
    
    // then you need to know what the multiplicator is
    // so you look for the fa icon classes
    // in order to work more easily on classes
    // we'll store them in an array
    // to do so, you just need to get all the classes
    // it will give you a string "class1 class2 ... classN"
    // so to split it into an array, we just need to pass space char as argument to split()
    // \s stands for space char in js regex
    var classes         = $(elementId).attr("class").split(/\s+/);
    
    $.each(classes, function(index, value){
        var pattern = new RegExp(/^fa\-[1-5]{1}x$/);
        if (pattern.test(value)) {
            var res = value.match(/[1-5]/);
            classes["multiplicator"] = res[0];
        }
    });
    
    return classes["multiplicator"]*resendNbIconWidth;
    
}