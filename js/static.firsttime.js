const generate_token = (length) => {
    //edit the token allowed characters
    var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
    var b = [];  
    for (var i=0; i<length; i++) {
        var j = (Math.random() * (a.length-1)).toFixed(0);
        b[i] = a[j];
    }
    return b.join("");
} 

let item = localStorage.getItem("FTczdV3");
if(!item) {
    $('#helpModal').css('display', 'block').addClass('show fade');
} else {
    $('#helpModal').attr("data-ipp-firsttime", "false");
}

const helpNext = () => { 
    var index = parseInt($('#helpModal .modal-content').attr('data-ipp-help-active')); $('#helpModal .modal-content').attr('data-ipp-help-active', `${index+1}`)
}
const helpPrev = () => { 
    var index = parseInt($('#helpModal .modal-content').attr('data-ipp-help-active')); $('#helpModal .modal-content').attr('data-ipp-help-active', `${index-1}`)
}
const helpClose = () => {
    $('#helpModal').removeClass('show fade').css('display', 'none').attr;
    if (!item) {
        localStorage.setItem("FTczdV3", generate_token(15))
    }
} 