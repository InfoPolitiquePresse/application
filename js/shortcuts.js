//keybinds shortcuts
const keyBinds = { 
    application: { fullscreen: "KeyF" },
    list: { deselect: "KeyK" },
    tabs: {
        close: "KeyR", //last: R | all: Shift + R
        resize: "KeyM", //last: Ctrl + , | all: Shift + ,
        window: /* Ctrl + */"Comma",
    },  
    search: { delete: /* Shift + */"KeyG", focusSearchBar: /* Shift + */"KeyY" }
};


document.onkeyup = e => {
    if ($('#searchInput').is(':focus') == false) {  //deny shortcuts if searchbar is being used

        if(e.code == keyBinds.application.fullscreen) {
            var fullScreenState =  $('#fsc-btn').attr('data-isFullscreen');
            if(fullScreenState=='true') closeFullscreen();
            else if(fullScreenState=='false') openFullscreen();
        };

        if(e.code == keyBinds.list.deselect) List.deselect();

        if(e.code == keyBinds.tabs.close) {
            if(e.shiftKey) document.querySelectorAll(".aInf-item").forEach(e => { e.remove() });
            else document.querySelector(".aInf-item:last-of-type").remove();
        }
    
        if(e.shiftKey && e.code == keyBinds.search.delete) emptySearchbar();
        if(e.shiftKey && e.code == keyBinds.search.focusSearchBar) document.getElementById("searchInput").focus();
        
        if(e.code == keyBinds.tabs.resize) {
            if(e.ctrlKey) document.querySelector(".aInf-item:last-of-type .aInf-options .aInf-btn:nth-child(2)").click();
            if(e.shiftKey) document.querySelectorAll(".aInf-item .aInf-options .aInf-btn:nth-child(2)").forEach(e => { e.click() });
        }
        if(e.ctrlKey && e.code == keyBinds.tabs.window) document.querySelector(".aInf-item:last-of-type .aInf-options .aInf-btn:nth-child(1)").click();
    }   
}