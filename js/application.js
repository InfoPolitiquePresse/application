const input = document.getElementById("searchInput");

input.addEventListener('keyup', () => {
    if (input.value) {
        $('.app-searcharea').addClass('used');
        List.search(input.value);
    } else emptySearchbar();
});

const emptySearchbar = () => {  
    $('.app-searcharea').removeClass('used')
    $('#searchInput').val("");
    $(".app-aside--item").css("display", "block");
}

document.getElementById('searchButton').addEventListener('click', () => { List.search(input.value); });

function itemhover(id) { $('#'+id).addClass('over'); }
function itemhovout(id) { $('#'+id).removeClass('over'); }



async function openFullscreen() {
    var elem = document.documentElement;
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }
    $('#fsc-btn').attr({ 'onclick': 'closeFullscreen()', 'data-isFullscreen': 'true'});
    $('#fsc-btn i').removeClass('bi-fullscreen').addClass('bi-fullscreen-exit');
}
async function closeFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { /* Safari */
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE11 */
      document.msExitFullscreen();
    }
    $('#fsc-btn').attr({ 'onclick': 'openFullscreen()', 'data-isFullscreen': 'false'});
    $('#fsc-btn i').removeClass('bi-fullscreen-exit').addClass('bi-fullscreen');
}

