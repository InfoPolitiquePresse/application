const jsonUrl = '../../js/data.json';
//jsonDB = fichier json de la base de donnée
const json = JSON.parse(jsonDB);
var coordy = [], coordx = [], selectedItemsTotal = 0;

var Application = {
    getData: function(i) {
        let n = json[i].Nom;
        let x = json[i].coordX || 'nothing';
        let y = json[i].coordY || 'nothing';
        var data = {
            "id": i,
            "letter": n.slice(0,1),
            "name": json[i].NomAffiche,
            "sortingName": n,
            "pol": json[i].Orien,
            "link": json[i].LiensExt,
            "prop": json[i].Proprietaire,
            "adre": json[i].Adresse,
            "desc": json[i].Description,
            "ech": json[i].Echelle,
            "type": json[i].Type,
            "coords": [x, y],
            "zone": "NE",
        };
        return data;
    },
    openInfo: function(i) {
        let inf = new Info(i);
        inf.open(Application.getData(i));
    },
    buildPopout: function(i) {
        let obj = new Popout(i);
        obj.open(Application.getData(i));
        obj.drag(document.getElementById('aPo-'+i))
    },
    closePopout: function(i) {
        $('#aPo-'+i).remove();
        $('#aInf-'+i).removeClass('popout');
        $('#aInf-'+i+' .aInfbtn-pop').attr('onclick', 'Application.buildPopout('+i+')');
        $('#aInf-'+i+' .aInfbtn-pop i').html('pageview');
    }
}
var List = {
    "element": $('.app-aside-list'),
    addItem: function(data) {
        let item = $("<div></div>").addClass('app-aside--item bg-card hoverable text-primary').attr({
            'id': 'listItem-'+data.id,
            'ipp-selected':'false',
            'onmouseover':'itemhover("plotPoint-'+data.id+'")',
            'onmouseout':'itemhovout("plotPoint-'+data.id+'")'
        });
        let itemOptions = $('<div></div>').addClass('app-aside--options').css({
            'float':'right',
            'padding':'8px'
        })
        .append(
            $('<i class="bi bi-square unselectable item--checkbox" style="cursor: pointer"></i>')
            .attr('onclick', 'List.select("'+data.id+'")')
        );
        let itemContent = $("<div></div>").addClass('app-aside--content').attr('onclick','Application.openInfo('+i+')');
        let itemTitle = $("<h4></h4>").html(data.name).addClass('app-aside--title');
        let itemLink = $('<a></a>').html(data.link).addClass('app-aside--link').attr({
            'href': data.link,
            'target':'_blank',
            'rel':'noopener noreferrer'
        });
        desc = data.desc;
        if (desc.length > 256) {
            textDesc = desc.slice(0,256) + '...';
        } else {
            textDesc = desc;
        }
        let itemDesc = $('<p></p>').html(textDesc).addClass('app-aside--desc');
        let itemPol = $(`<span class="badge-orien" data-ipp-oriencol="${data.pol}"></span>`).html(data.pol);
        $(itemContent).append(itemTitle, itemLink, itemDesc, itemPol);
        $(item).append(itemOptions, itemContent);
        $(this.element).append(item);
    },
    select: async function(id) {
        itemSel = $('#listItem-'+id).attr('ipp-selected')
        if (itemSel=='false') {     //select
            $('#listItem-'+id+' .item--checkbox').addClass('bi-check-square-fill').removeClass('bi-square');
            $('#listItem-'+id).attr('ipp-selected','true')
            $('#plotPoint-'+id).attr('ipp-selected', 'true').addClass('selected');
            selectedItemsTotal++;
        } else {                    //deselect
            $('#listItem-'+id+' .item--checkbox').removeClass('bi-check-square-fill').addClass('bi-square');
            $('#listItem-'+id).attr('ipp-selected','false')
            $('#plotPoint-'+id).attr('ipp-selected', 'false').removeClass('selected');
            selectedItemsTotal--;
        }
        if (selectedItemsTotal>0) { $('#itemDeselector').css('display', ''); }
        else $('#itemDeselector').css('display', 'none');
        if (selectedItemsTotal>1) {
            var selected = document.querySelectorAll('.app-aside--item[ipp-selected="true"]'), x = [], y = [];
            selected.forEach( e => {
                var idstr = e.id, id = idstr.split("-");
                var data = Application.getData(id[1]);
                x.push(data.coords[0]); y.push(data.coords[1]);
            })
            const moyenne = (array) => {
                var b = array.length, c = 0, i;
                for (i in array) c += Number(array[i]);
                return c/b;
            }
            $("#med-point").css({"display":"block", "bottom":`${moyenne(y)}%`, "left":`${moyenne(x)}%`});
        }
        else $("#med-point").css({"display":"none", "bottom":"", "left":""});
    },
    deselect: function() {
        $('.app-aside--item .item--checkbox').removeClass('bi-check-square-fill').addClass('bi-square');
        $('.app-aside--item').attr('ipp-selected','false').css('background','');
        $('.plot-point').attr('ipp-selected', 'false').removeClass('selected');
        selectedItemsTotal = 0;
        $('#itemDeselector').css('display', 'none');
        $("#med-point").css({"display":"none", "bottom":"", "left":""});
    },
    search: function(str) {
        var filter, listitems, match;
        filter = str.toLowerCase().replace(/[\u0300-\u036f' ]/g, "");
        listitems = document.querySelectorAll('.app-aside--item');
        listitems.forEach(item => {
            match = item.getElementsByTagName('h4')[0].innerText.toLowerCase().replace(/[\u0300-\u036f' ]/g, "");
            if (match.indexOf(filter) <= -1) item.style.display = "none";
            else item.style.display = "";
        })
    },
    sort: function() {
        this.element.empty();
        var filter = $('#filter').val(), i;
        if (filter.includes('default')) for (i in json) { List.addItem(Application.getData(i)) };
        if (filter.includes('reverse')) {
            json.reverse();
            for (i in json) List.addItem(Application.getData(i)) 
            json.reverse();
        };
    }
    
}
var Graph = {
    addPoint: function(data) {
        var pointPlacement = '', ttPlacement = "";
        if (isNaN(data.coords[0]) || isNaN(data.coords[0])) pointPlacement = "display: none";
        else pointPlacement = "left: calc(" + data.coords[0] + "% - 1.5vh); bottom: calc(" + data.coords[1] +"% - 1.5vh);";
        if (data.coords[0]<=50) ttPlacement = "left: 4vh; top: -0.75vh";
        else ttPlacement = "right: 4vh; top: -0.75vh";

        var point = $('<a class="plot-point"></a>').attr({
            "id": `plotPoint-${data.id}`,
            "data-id": data.id,
            "href": `#listItem-${data.id}`,
            "style": pointPlacement,
            "onclick": `Application.openInfo(${data.id})`,
        }).append($('<div class="plot-icon bg-alt text-lighter"></div>')
        .append($('<p class="pp-letter"></p>').html(data.letter))
        .append(
            $('<div class="plot-tooltip bg-card text-primary"></div>')
            .attr({
                "id": "plotTooltip-"+data.id,
                "style": ttPlacement,
            })
            .append($('<h5 class="ptt-title"></h5>').html(data.name))
            .append($('<p class="ptt-pol"></p>').html(data.pol))
        ));
        $('.plot-container').append(point);
    },
}

class Info {
    constructor(id) { this.id = id }
    open(data) {
        if (!document.getElementById("aInf-"+this.id)) {
            let container = $('<div class="aInf-item bg-card"></div>').attr("id", "aInf-"+this.id);
            let head = $('<div class="aInf-head text-light"></div>')
                .append($('<h2></h2>').html(data.name))
                .append($('<a class="text-secondary" target="_blank"></a>').attr("href", data.link).html(data.link))
            let content = $('<div class="aInf-content bg-alt text-primary"></div>')
                .append($(`<span class="badge-orien" data-ipp-oriencol="${data.pol}"></span>`).html(data.pol)).append($('<br>'))
                .append($('<p class="aInf-ech"></p>').html(data.ech)).append($('<br>'))
                .append($('<p class="aInf-type"></p>').html(data.type)).append($('<br>'))
                .append($('<p class="aInf-desc text-justify"></p>').html(data.desc)).append($('<br>'))
                .append($('<p class="aInf-prop"></p>').html(data.prop)).append($('<br>'))
                .append($('<p class="aInf-adre"></p>').html(data.adre)).append($('<br>'))
            let options = $('<div class="aInf-options"></div>')
                .append($('<button class="aInf-btn aInfbtn-pop bg-card hoverable text-secondary"></button>').attr("onclick", "Application.buildPopout("+this.id+")").append('<i class="material-icons">pageview</i>'))
                .append($('<button class="aInf-btn aInfbtn-min bg-card hoverable text-secondary"></button>').attr("onclick", "$('#aInf-"+this.id+"').toggleClass('popout')").append('<i class="material-icons">keyboard_arrow_up</i>'))
                .append($('<button class="aInf-btn bg-card hoverable text-secondary"></button>').attr("onclick", "$('#aInf-"+this.id+"').remove();").append('<i class="material-icons">close</i>'))
            container.append(head, content, options);
            $('.aInf-container').append(container);
        } else $('#aInf-'+this.id).remove();
    }
}
class Popout {
    constructor(id) { this.id = id }
    open(data) {
        $('#aInf-'+this.id).addClass('popout');
        $('#aInf-'+this.id+' .aInfbtn-pop').attr('onclick', 'Application.closePopout('+this.id+')');
        $('#aInf-'+this.id+' .aInfbtn-pop i').html('view_agenda');
        if (!document.getElementById("aPo-"+this.id)) {
            let container = $('<div class="aPo"></div>').attr("id", "aPo-"+this.id);
            let header = $('<div class="aPo-header bg-main text-secondary"></div>')
                .append($('<button class="aPo-close bg-main hoverable" onclick="Application.closePopout('+this.id+')"><i class="material-icons">close</i></button>'));
            let head = $('<div class="aInf-head bg-main text-light"></div>')
                .append($('<h2></h2>').html(data.name))
                .append($('<a class="text-secondary" target="_blank"></a>').attr("href", data.link).html(data.link))
            let content = $('<div class="aPo-content bg-card text-primary"></div>')
                .append($(`<span class="badge-orien" data-ipp-oriencol="${data.pol}"></span>`).html(data.pol)).append($('<br>'))
                .append($('<p class="aPo-echelle-type"></p>').html(data.ech+' / '+data.type)).append($('<br>'))
                .append($('<p class="aPo-desc text-justify"></p>').html(data.desc)).append($('<br>'))
                .append($('<p class="aPo-prop"></p>').html(data.prop)).append($('<br>'))
                .append($('<p class="aPo-adresse"></p>').html(data.adre)).append($('<br>'))
            container.append(header, head, content)
            $('body').append(container);
        }  
    }
    drag(elmnt) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        document.querySelector('#aPo-'+this.id+' .aPo-header').onmousedown = dragMouseDown;
        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }
        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }
        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
}

$('document').ready( async () => {
    for (i in json) {
        List.addItem(Application.getData(i))      //construct list
        Graph.addPoint(Application.getData(i))    //construct graph
        List.search(input.value);
    }
})
