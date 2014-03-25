function addLoadEvent(func){
    var oldonload=window.onload;
    if(typeof window.onload!="function"){
        window.onload=func;
    }else{
        window.onload=function(){
            if(oldonload){		//fix an runtime error in IE7
                oldonload();
            }
            func();
        }
    }
}

function externalLinks(){
    var anchors=document.getElementsByTagName("a");
    for(var i=0;i<anchors.length;i++){
        var anchor=anchors[i];
        if(anchor.getAttribute("href").toLowerCase().indexOf("http://")!=-1&&anchor.getAttribute("rel")=="external"){
            anchor.target="_blank";
            anchor.className="external";
        }
    }
}

var Roller={
    lists:null,
    init:function(navId,config){
        this.lists=document.getElementById(navId).getElementsByTagName("li");
        var list,anchor;
        for(var i=0;i<this.lists.length;i++){
            list=this.lists[i];
            if(list.className=="current"){
                continue;
            }
            anchor=list.childNodes[0].cloneNode(true);
            anchor.className="hover";
            list.scrollTimeId=null;
            list.onmouseover=function(){
                if(this.scrollTimeId){
                    clearTimeout(this.scrollTimeId);
                }
                Roller.scrollUp(this,config);
            };
            list.onmouseout=function(){
                if(this.scrollTimeId){
                    clearTimeout(this.scrollTimeId);
                }
                Roller.scrollDown(this,config);
            };
            list.appendChild(anchor);
        }
    },
    scrollUp:function(e,config){
        if(e.scrollTop>=e.offsetHeight){
            e.scrollTop=e.offsetHeight;
        }else{
            e.scrollTop+=config.distance;
            e.scrollTimeId=setTimeout(function(){
                Roller.scrollUp(e,config);
            },config.delay);
        }
    },
    scrollDown:function(e,config){
        if(e.scrollTop<=0){
            e.scrollTop=0;
        }else{
            e.scrollTop-=config.distance;
            e.scrollTimeId=setTimeout(function(){
                Roller.scrollDown(e,config);
            },config.delay);
        }
    }
}

var Starsky={
    currentOffsetX:0,
    init:function(){
        var backgroundImage=new Image();
        backgroundImage.onload=function(){
            Starsky.updateBackground(this.width);
        };
        backgroundImage.src="images/starsky.jpg";
    },
    updateBackground:function(width){
        if(-this.currentOffsetX>width){
            this.currentOffsetX=0;
        }else{
            this.currentOffsetX--;
        }
        document.body.style.backgroundPosition=this.currentOffsetX+"px "+0;
        setTimeout(function(){
            Starsky.updateBackground(width);
        },50);
    }
}

function createXHR(){
    var xhr=null;
    if(typeof XMLHttpRequest!="undefined"){
        xhr=new XMLHttpRequest();
    }else if(typeof ActiveXObject!="undefined"){
        if(typeof arguments.callee.activeXString!="string"){
            var versions=["MSXML2.XMLHttp.6.0","MSXML2.XMLHttp.3.0","MSXML2.XMLHttp"];
            for(var i=0;i<versions.length;i++){
                try{
                    xhr=new ActiveXObject(versions[i]);
                    arguments.callee.activeXString=versions[i];
                }catch(e){
                //skip
                }
            }
        }else{
            xhr=new ActiveXObject(arguments.callee.activeXString);
        }
    }else{
        xhr=null;
        throw new Error("No XMLHttpRequest object available.");
    }
    return xhr;
}
function stripeTables() {
    if (!document.getElementsByTagName) return false;
    var tables = document.getElementsByTagName("tbody");
    if (!tables) return false;
    for (var i=0; i<tables.length; i++) {
        var odd = false;
        var rows = tables[i].getElementsByTagName("tr");
        for (var j=0; j<rows.length; j++) {
            if (odd == true) {
                addClass(rows[j],"odd_row");
                odd = false;
            } else {
                addClass(rows[j],"even_row");
                odd = true;
            }
        }
    }
}
function addClass(element,value) {
    if (!element.className) {
        element.className = value;
    } else {
        newClassName = element.className;
        newClassName+= " ";
        newClassName+= value;
        element.className = newClassName;
    }
}

function highlightPage() {
    var nav = document.getElementById("nav");
    if(!nav) return false;
    var links = nav.getElementsByTagName("a");
    for (var i=0; i<links.length; i++) {
        var linkurl = links[i].getAttribute("href");
        var currenturl = window.location.href;
        linkurl.length=linkurl.length-1;
        if (currenturl.indexOf(linkurl) != -1) {
            links[i].parentNode.className = "current";
        }
    }
}


function highlightRows() {
    if(!document.getElementsByTagName) return false;
    var rows = document.getElementsByTagName("tr");
    for (var i=0; i<rows.length; i++) {
        rows[i].oldClassName = rows[i].className
        rows[i].onmouseover = function() {
            addClass(this,"hover");
        }
        rows[i].onmouseout = function() {
            this.className = this.oldClassName
        }
    }
}

addLoadEvent(highlightPage);
addLoadEvent(stripeTables);
addLoadEvent(highlightRows);
//execute code on page load
addLoadEvent(function(){
    //add attribute target="_blank" to anchors which has an attribute of rel="external" 
    //externalLinks();
    //enable roller navigator menu
    //document.getElementById("navWithoutJs").removeAttribute("id");
    Roller.init("nav",{
        delay:10,
        distance:5
    });
//enable animated backgound
//Starsky.init();
//enbale text gradiant by prepending a span tag
//var h1=document.getElementById("logo");
//h1.insertBefore(document.createElement("span"),h1.childNodes[0]);
//show page last modified date
//var p=document.createElement("p");
//p.appendChild(document.createTextNode("Last Modified: "+document.lastModified));
//document.getElementById("footer").appendChild(p);
});
