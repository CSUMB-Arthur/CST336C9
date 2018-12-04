function updateImgPositions(){
    spawn.element.css("left",Math.round(spawn.X-camera.X));
    spawn.element.css("top",Math.round(spawn.Y-camera.Y));
    
    for (var wall of walls){
        //console.log("Updating position of wall "+wall.id);
        wall.element.css("left",Math.round(wall.x1-camera.X));
        wall.element.css("top",Math.round(wall.y1-camera.Y));
    }
    
    exit.element.css("left",Math.round(exit.X-camera.X));
    exit.element.css("top",Math.round(exit.Y-camera.Y));
    
    
    wallpoints[0].element.css("left",Math.round(wallpoints[0].X-camera.X-3));
    wallpoints[0].element.css("top",Math.round(wallpoints[0].Y-camera.Y-3));
    
    wallpoints[1].element.css("left",Math.round(wallpoints[1].X-camera.X-3));
    wallpoints[1].element.css("top",Math.round(wallpoints[1].Y-camera.Y-3));
    
}

function updateUI(){
    
}

function modeSelect(i){
    if (i != mode){
        $("#button"+mode).removeClass("selected");
        mode = i;
        $("#button"+mode).addClass("selected");
        showWallPoints(0);
        switch (mode){
            case 0://add wall mode
                showWallPoints(0);
                break;
            case 1://place spawn mode
            case 2://place exit mode
                showWallPoints(0);
                break;
            case 3://selection/drag mode
                if (selected != null){
                    if (selected.type == "wall"){
                        showWallPoints(2);
                    }
                }
                break;
        }
    }
}

function getWallPointCount(){
    var count = 0;
    if (wallpoints[0].element.css("visibility") == "visible") {
        count++;
    }
    if (wallpoints[1].element.css("visibility") == "visible") {
        count++;
    }
    return count;
}

function showWallPoints(number){
    switch (number){
        case 0:
            wallpoints[0].element.css("visibility","hidden");
            wallpoints[1].element.css("visibility","hidden");
            break;
        case 1:
            wallpoints[0].element.css("visibility","visible");
            wallpoints[1].element.css("visibility","hidden");
            break;
        case 2:
            wallpoints[0].element.css("visibility","visible");
            wallpoints[1].element.css("visibility","visible");
            break;
        
    }
}

function initWallPoints(){
    gameWindow.append("<span id='wallPointA' class='point object'></span>");
    gameWindow.append("<span id='wallPointB' class='point object'></span>");
    
    wallpoints = [];
    wallpoints.push({"element":$("#wallPointA"),X:0,Y:0,type:"wallpoint"});
    wallpoints.push({"element":$("#wallPointB"),X:0,Y:0,type:"wallpoint"});
    
    wallpoints[0].element.css("visibility","hidden");
    
    showWallPoints(0);

}

function initUI(){
    gameWindow.append("<div id='UI' class='object' width = '800' height='80'></div>");
    $("#UI").css("bottom", "5px");
    $("#UI").css("left", "5px");
    //src='img/dog.png'
    $("#UI").append("<button id ='button0' class='modebutton' width='100'>Add Walls</button>");
    $("#UI").append("<button id ='button1' class='modebutton' width='100'>Set Spawn</button>");
    $("#UI").append("<button id ='button2' class='modebutton' width='100'>Set Exit</button>");
    $("#UI").append("<button id ='button3' class='modebutton' width='100'>Select</button>");
    
    //set default
    mode = 0;
    $("#button0").addClass("selected");
    
    $("#button0").click(function(e){
        modeSelect(0);
    });
    $("#button1").click(function(e){
        modeSelect(1);
    });
    $("#button2").click(function(e){
        modeSelect(2);
    });
    $("#button3").click(function(e){
        modeSelect(3);
    });
    
}

function initSpawn(){
    gameWindow.append("<img id='spawn' class='object' src='img/transparent.gif' width='32' height='32'>");
    return {"element":$("#spawn"),X:200,Y:200,type:"spawn"};
}

function initExit(){
    gameWindow.append("<img id='exit' class='object' src='img/exit.png'>");
    return {"element":$("#exit"),X:200,Y:0,type:"exit"};
}

function init(){
    gameWindow = $("#gameWindow");

    timer = setInterval(updateInfo,18)
    timer2 = setInterval(updateImgPositions,18)
    spawn = initSpawn();
    walls = [];
    selected = null;
    debugInfo = $("#debugInfo");
    exit = initExit();
    wallpoints = [];
    initWallPoints();
    initUI();
    initInputs();
    maxlength = 3;
    loadLevel("Z2Wr5Wc2Wg8Wv1Wx6W86WJ8Wu1Wf0WB6WDAWL7WN5WI9WNAW");
}

function initInputs(){

    gameWindow.on("mousedown",
        function(e){
            //prevent left clicking from doing stuff while selecting things in gameWindow (such as highlighting imgs)
            e.preventDefault();
            //e.buttton, 0 = leftclick, 2 = rightclick.
            mouseDrag = e.button;
            var offset = $("#gameWindow").offset();
            mousePrevX = e.pageX - offset.left;
            mousePrevY = e.pageY - offset.top;
            
            if ((mouseCurrentX < 5 || mouseCurrentX > 405
                || mouseCurrentY < 555 || mouseCurrentY > 595) 
                && e.button == 0 && released == 1){
                switch (mode){
                    case 0:
                        var existingPoints = getWallPointCount();
                        var minX;
                        var minY;
                        var maxX;
                        var maxY;
                        
                        switch (existingPoints){
                            case 2:
                            case 0:
                                wallpoints[0].X = camera.X + mouseCurrentX;
                                wallpoints[0].Y = camera.Y + mouseCurrentY;
                                showWallPoints(1);
                                break;
                            case 1:
                                wallpoints[1].X = camera.X + mouseCurrentX;
                                wallpoints[1].Y = camera.Y + mouseCurrentY;
                                showWallPoints(2);
                                
                                minX = Math.min(wallpoints[0].X, wallpoints[1].X);
                                maxX = Math.max(wallpoints[0].X, wallpoints[1].X);
                                
                                minY = Math.min(wallpoints[0].Y, wallpoints[1].Y);
                                maxY = Math.max(wallpoints[0].Y, wallpoints[1].Y);
                                
                                resizableObj = createWall(minX,minY,maxX,maxY);
                                break;
                        }
                        
                        //add walls
                        break;
                    case 1:
                        //create spawn point if it doesn't exist
                        //otherwise, just move its position
                        if (spawn == null){
                            spawn = initSpawn();
                        }
                        spawn.X = mouseCurrentX+camera.X;
                        spawn.Y = mouseCurrentY+camera.Y;
                        
                        break;
                    case 2:
                        //create exit point if it doesn't exist
                        //otherwise, just move its position
                        if (exit == null){
                            exit = initExit();
                        }
                        exit.X = mouseCurrentX+camera.X;
                        exit.Y = mouseCurrentY+camera.Y;
                        break;
                    case 3:
                        //select an object
                        selectObject(mouseCurrentX,mouseCurrentY);
                        break;
                }

            }
            released = 0;
        }
    );
    
    $(document).on("mouseup",
        function(e){
            mouseDrag = -1;
            released = 1;
            selected = null;

        }
    )
    
    gameWindow.on("contextmenu",
        function(e){
            //Just disables menu from opening on right click.
            e.preventDefault();

        }
    );
    
    $(document).on("keydown",
        function(e){
            //Get and utilize key inputs
            //arrow keys should scroll around
            //delete should delete a value
            var key = e.which

            if (key == 46 || key == 37 || key == 38 || key == 39 || key == 40){
                
                switch (key){
                    case 46:
                        if (resizableObj != null){
                            console.log("deleting wall");
                            deleteWall(resizableObj);
                            showWallPoints(0);
                        }
                        break;
                }
                e.preventDefault();
            } 
        }
    );
    
    $(document).on("mousemove",function(e){

        var offset = $("#gameWindow").offset();
        mouseCurrentX = e.pageX - offset.left;
        mouseCurrentY = e.pageY - offset.top;
        //if rightmouse is held down
        if (mouseDrag == 2){
            dragScreen();
        }
        if (mouseDrag == 0 && selected != null){
            dragObject(selected);
            //drag selected
        }
        //console.log("Moved. Xv: "+x+"Yv: "+y);
    });
    
    $("#generate").click(
        function(e){
            encodeLevel();
            
        }
    );

    $("#loadLevel").click(
        function(e){
            str = $("#levelcode").prop("value");
            //console.log("string: "+str);
            loadLevel(str);
        }
    );
    
    //Add a button to generate the code for the level.
}

function selectObject(X,Y){
    X = camera.X + X;
    Y = camera.Y + Y;
    //check if spawn was clicked on
    if (X <= spawn.X+31 && X >= spawn.X
    && Y <= spawn.Y+31 && Y >= spawn.Y){
        selected = spawn;
        return true;
    }
    
    //check if exit was clicked on
    if (X <= exit.X+95 && X >= exit.X
    && Y <= exit.Y+95 && Y >= exit.Y){
        selected = exit;
        return true;
    }
    
    for (var wallpoint of wallpoints){
        
        var radiusSquared = (X-wallpoint.X)*(X-wallpoint.X)+(Y-wallpoint.Y)*(Y-wallpoint.Y);
        if (radiusSquared <= 4*4){
            selected = wallpoint;
            return true;
        }
    }
    
    console.log("Selecting object");
    for (var wall of walls){
        //iterate through all walls, check if it contains the mouse point
        //break and return the first wall
        //console.log("Checking wall "+wall.element.attr('id'));
        if (X <= wall.x2+6 && X >= wall.x1-6
            && Y <= wall.y2+6 && Y >= wall.y1-6){
            wallpoints[0].X = wall.x1;
            wallpoints[0].Y = wall.y1;
            wallpoints[1].X = wall.x2;
            wallpoints[1].Y = wall.y2;
            showWallPoints(2);
            selected = wall;
            resizableObj = wall;
            return true;
            break;
        }
    }
    return false;

}

function deleteWall(wall){
    console.log("removed index: "+wall.index);
    console.log("before: ");
    console.log(walls);
    wall.element.remove();
    
    index = wall.index;
    //replace wall in array with value from end of array
    walls[index] = walls[walls.length-1];
    
    //update newly moved wall with new index
    walls[index].index = index;
    
    //update it's element id as well, so that it doesn't get selected by accident
    //when a new wall is generated
    walls[index].element.attr('id',"wall"+wall.index)
    walls.length--;
    console.log("After: ");
    console.log(walls);
    showWallPoints(0);
    resizableObj = null;
    selected = null;
}

function deleteExit(){
    exit.element.remove();
    exit = null;
}

function deleteSpawn(){
    spawn.element.remove();
    spawn = null;
}

function createWall(left, top, right, bottom){
    var wallid = "wall"+walls.length;
    var height = bottom-top + 1;
    var width = right-left +1;
    var ele;
    left = Math.round(left);
    top = Math.round(top);
    right = Math.round(right);
    bottom = Math.round(bottom);
    gameWindow.append("<img id='" + wallid + "' class='object wall' src='img/transparent.gif'>");
    ele = $("#"+wallid);
    var wall = {"element":ele, x1:left, y1:top, x2:right, y2:bottom,type:"wall",index:walls.length};
    ele.css("border", "1px dotted gray");
    wall.element.css("left",left);
    wall.element.css("top",top);
    wall.element.css("height",height);
    wall.element.css("width",width);
    wall.element.css("background-color","white");
    walls.push(wall);
    console.log("Wall created: "+wall.element.css('left')+","+wall.x1+","+wall.y1+","+wall.x2+","+wall.y2);
    return wall;
}

function clearWalls(){
    for (var wall of walls){
        wall.element.remove();
    }
    walls.length = 0;
}

function setCameraPosition(X,Y){
    camera.X = X;
    camera.Y = Y;
}

function dragScreen(){
    var deltaX = mousePrevX - mouseCurrentX;
    var deltaY = mousePrevY - mouseCurrentY;
    mousePrevX = mouseCurrentX;
    mousePrevY = mouseCurrentY;
    camera.X += deltaX;
    camera.Y += deltaY;
}

function dragObject(Obj){
    var deltaX = mouseCurrentX - mousePrevX ;
    var deltaY = mouseCurrentY - mousePrevY;
    mousePrevX = mouseCurrentX;
    mousePrevY = mouseCurrentY;
    if (Obj.type == "wall"){
        Obj.x1 += deltaX;
        Obj.y1 += deltaY;
        Obj.x2 += deltaX;
        Obj.y2 += deltaY;
        wallpoints[0].X += deltaX;
        wallpoints[0].Y += deltaY;
        wallpoints[1].X += deltaX;
        wallpoints[1].Y += deltaY;
        
        
    }
    else{ //must be exit or spawn
        Obj.X += deltaX;
        Obj.Y += deltaY;
        
        if (Obj.type == "wallpoint"){
            updateWall(resizableObj);
        }
    }
}

function updateWall(wall){
    minX = Math.min(wallpoints[0].X, wallpoints[1].X);
    maxX = Math.max(wallpoints[0].X, wallpoints[1].X);
    
    minY = Math.min(wallpoints[0].Y, wallpoints[1].Y);
    maxY = Math.max(wallpoints[0].Y, wallpoints[1].Y);
    
    wall.x1 = minX;
    wall.x2 = maxX;
    wall.y1 = minY;
    wall.y2 = maxY;
    
    
    wall.element.css("width", (wall.x2 - wall.x1 + 1) + "px");
    wall.element.css("height", (wall.y2 - wall.y1 + 1) + "px");
    
    //Prevents odd visual effects when width is adjusted, but left and top are
    //no adjusted until the next update interval
    wall.element.css("top",wall.y1-camera.Y);
    wall.element.css("left",wall.x1-camera.X);
    
    wallpoints[0].element.css("left",Math.round(wallpoints[0].X-camera.X-3));
    wallpoints[0].element.css("top",Math.round(wallpoints[0].Y-camera.Y-3));
    
    wallpoints[1].element.css("left",Math.round(wallpoints[1].X-camera.X-3));
    wallpoints[1].element.css("top",Math.round(wallpoints[1].Y-camera.Y-3));
    
}

function updateInfo(){
    debugInfo.empty();
    debugInfo.append("cameraX: "+camera.X+"<br/>");
    debugInfo.append("cameraY: "+camera.Y+"<br/>");
    debugInfo.append("mouseX: "+mouseCurrentX+"<br/>");
    debugInfo.append("mouseY: "+mouseCurrentY+"<br/>");
    
    if (selected != null){
        debugInfo.append("selected: "+selected.type+"<br/>");
        //$("#debugInfo").append("id: "+selected.id+"<br/>");
        switch (selected.type){
            case "wall":
                debugInfo.append("x1: "+selected.x1+"<br/>");
                debugInfo.append("y1: "+selected.y1+"<br/>");
                debugInfo.append("x2: "+selected.x2+"<br/>");
                debugInfo.append("y2: "+selected.y2+"<br/>");
                break;
            case "spawn":
            case "exit":
            case "wallpoint":
                debugInfo.append("X: "+selected.X+"<br/>");
                debugInfo.append("Y: "+selected.Y+"<br/>");
                break;
        }
    }
    else{
        debugInfo.append("selected: None <br/>");
    }

}



function encodeLevel(){
    //output level creation text to area
    outputArea = $("#outputArea");
    if (spawn != null && exit != null){
        outputArea.empty();

        
        //spawn
        outputArea.append(encodeInt(spawn.X)+encodeInt(spawn.Y));
        
        //exit
        outputArea.append(encodeInt(exit.X)+encodeInt(exit.Y));
        
        //walls
        for (var wall of walls){
            outputArea.append(encodeInt(wall.x1)+encodeInt(wall.y1)+encodeInt(wall.x2)+encodeInt(wall.y2));
        }

    }
    else{
        if (spawn == null) outputArea.append("No spawn point set");
        if (exit == null) outputArea.append("No exit set");
    }
    
}

function loadLevel(str){
    if (str.length < 6 || str.length%3 != 0 ){

        $("#levelcode").empty();
        $("#levelcode").prop("value","INVALID");
        return 0;
    }

    
    var spawnX = decodeStr(str.slice(0,3));
    var spawnY = decodeStr(str.slice(3,6));
    
    var exitX = decodeStr(str.slice(6,9));
    var exitY = decodeStr(str.slice(9,12));
    
    clearWalls();

    if (spawn == null){
        spawn = initSpawn();
    }
    spawn.X = spawnX;
    spawn.Y = spawnY;
    
    if (exit == null){
        exit = initSpawn();
    }
    exit.X = exitX;
    exit.Y = exitY;
        
    var x1;
    var y1;
    var x2;
    var y2;
    
    for (var i = 0; i < (str.length-12)/12 ;i++){
        x1 = decodeStr(str.slice(12+12*i,15+12*i))
        y1 = decodeStr(str.slice(15+12*i,18+12*i))
        x2 = decodeStr(str.slice(18+12*i,21+12*i))
        y2 = decodeStr(str.slice(21+12*i,24+12*i))
        createWall(x1,y1,x2,y2);
    }
    console.log(walls);
}

function encodeInt(val){
    console.log("encoding value "+val);
    min = -Math.pow(alphabet.length,maxlength)/2;
    max = -min - 1;
    if (val >= min && val <= max){
        val -= min;
        
        //console.log("adjusted value "+val);
        //console.log("min value: "+min);
        //console.log("max value: "+max);
        s="";
        
        var index;
        for (i=1;i<=maxlength;i++){
            r = val%Math.pow(alphabet.length,i)
            //console.log(r);
            index = r/Math.pow(alphabet.length,i-1);
            //console.log(index);
            s = s+alphabet[index];
            val -= r;
        }
    return s;
    }
    else{
        return "!INVALID INTEGER!";
    }
}

function decodeStr(str){
    
    var c;
    var val = 0;
    for (var i = 0; i < str.length; i++){
        c = alphabetmap[str.charAt(i)];
        val += c * Math.pow(alphabet.length,i);
    }
    var min = -Math.pow(alphabet.length,maxlength)/2;
    //console.log("Decoding "+str+" = "+ (val + min + 1));
    return val + min;
}

function initAlphabetMap(){
    alphabetmap = [];
    for (var i in alphabet){
        alphabetmap[alphabet[i]] = i;
    } 
}


var alphabet = ("1234567890ABCDEFGHIJKLMNOPQWSTUVWXYZabcdefghijklmnopqrstuvwxyz+-");
var alphabetmap;
initAlphabetMap();
var gameWindow;
var timer;
var timer2;
var selected;
var mousePrevX;
var mousePrevY;
var mouseCurrentX;
var mouseCurrentY;
var spawn;
var exit;
var walls;
var camera = {X:0,Y:0};
var maxlength;
var mouseDrag = -1;
var mode;
var wallpoints;
var debugInfo
var released = 1;
var resizableObj = null;
window.onload = init();

