function moveImg(){
    
    $("#"+selected.id).css("left",selected.x);
    $("#"+selected.id).css("top",selected.y);
}

function getCollision(){
    
}
//Program starting point, creates global variables, and initializes them

var objA = {id:"A",x:300,y:200,width:128,height:32,xv:0,yv:0};
var objB = {id:"B",x:333,y:333,width:64,height:64};
var minkowski = {id:"C",x:0,y:0,width:0,height:0};
var selected;
var offsetx;
var offsety;
var Timer = null;
var collisionLine = {x:0,y:0,x2:0,y2:0};
$("#gameWindow").append("<img id='A' class='object' src='img/transparent.gif'>");
$("#gameWindow").append("<img id='B' class='object' src='img/transparent.gif'>");
$("#gameWindow").append("<img id='C' class='object' src='img/transparent.gif'>");


$("#A").on("onmousedown",function(e){
    e.preventDefault();
    selected = objA;
    Timer = setInterval(moveImg, 1000/24);
});

$("#gameWindow").on("onmouseup",function(e){
    if (Timer != null){
        clearInterval(Timer);
    }
});

$("#A").css("left",objA.x);
$("#A").css("top",objA.y);
$("#A").attr("width",objA.width);
$("#A").attr("height",objA.height);

$("#B").css("left",objB.x);
$("#B").css("top",objB.y);
$("#B").attr("width",objB.width);
$("#B").attr("height",objB.height);

minkowski.x = objB.x - objA.width;
minkowski.y = objB.y - objA.height;
minkowski.width = objB.width + objA.width;
minkowski.height = objB.height + objA.height;

$("#C").css("left",minkowski.x);
$("#C").css("top",minkowski.y);
$("#C").attr("width",minkowski.width);
$("#C").attr("height",minkowski.height);

var collision = false;
if (objA.x <= minkowski.x+minkowski.width 
    && objA.x >= minkowski.x 
    && objA.y <= minkowski.y+minkowski.width 
    && objA.y >= minkowski.y){
    
    collision = true;
}
$("#debugInfo").empty();
$("#debugInfo").append("collision: "+collision+"<br/>");