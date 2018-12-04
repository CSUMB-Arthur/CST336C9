function updateImgPositions(){
    playerObj.element.css("left",Math.round(playerObj.X-camera.X));
    playerObj.element.css("top",Math.round(playerObj.Y-camera.Y));
    
    for (var wall of walls){
        //console.log("Updating position of wall "+wall.id);
        wall.element.css("left",Math.round(wall.x1-camera.X));
        wall.element.css("top",Math.round(wall.y1-camera.Y));
    }
    
    exit.element.css("left",Math.round(exit.X-camera.X));
    exit.element.css("top",Math.round(exit.Y-camera.Y));
}

function updateUI(){
    
}

function initSpawn(){
    //No spawn visual in the actual game, only the level editor.
    //gameWindow.append("<img id='spawn' class='object' src='img/transparent.gif' width='32' height='32'>");
    return {X:200,Y:200,type:"spawn"};
}

function initExit(){
    gameWindow.append("<img id='exit' class='object' src='img/exit.png'>");
    $("#exit").css("visibility","hidden");
    return {"element":$("#exit"),X:-9999999,Y:0,type:"exit",width:96,height:96};
}

function initInputs(){
    $(document).keydown(
        function(e){
            
            var index = keyToIndex[e.which];
            //Disable up/down scrolling behaviour
            if (e.which == 38 || e.which == 40){
                e.preventDefault();
            }
            if (index != undefined){
                keystates[index] = true;

            }
            
        }
    )
    
    $(document).keyup(
            function(e){
                var index = keyToIndex[e.which];
                
                if (index != undefined){
                    keystates[index] = false;
                }
                
            }
        )
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
    gameWindow.append("<img id='" + wallid + "' class='object wall' src='img/transparent.gif' height='"+ height +"' width='"+ width +"'>");
    ele = $("#"+wallid);
    var wall = {"element":ele, x1:left, y1:top, x2:right, y2:bottom,type:"wall",index:walls.length};
    
    wall.element.css("left",left);
    wall.element.css("top",top);
    
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
    
function wallAdjacent(obj,direction){
    for (var wall of walls){
        if (wall.x2 == obj.X-1 && direction == "left"){
            return true;
        }
        
        if (wall.x1 == obj.X+obj.width && direction == "right"){
            return true;
        }
    }

    return false;
}

function updateCameraPosition(){
    var cameraTargetX = (playerObj.X+playerObj.width/2) - 400 + 3.5*playerObj.Xv;
    var deltaX = cameraTargetX-camera.X;
    camera.X = camera.X + .30 * deltaX;
    
    var cameraTargetY = (playerObj.Y+playerObj.height/2) - 300
    
    if (keystates[3] || keystates[5]){
        //up
        if (keystates[3]){
            cameraTargetY += -200;
        }
        
        //down
        if (keystates[5]){
            cameraTargetY += +200;
        }
    }
    var deltaY = cameraTargetY-camera.Y;
    camera.Y = camera.Y + .40 * deltaY;
}

function getIndexOfSmallestValidTime(somearray){
    if (somearray.length <= 0){
        return -1;
    }
    var min = 2;
    var minIndex = -1;
    for (var index in somearray){
        if (somearray[index] >= 0 && somearray[index] <= 1){
            if (somearray[index] <= min){
                if (somearray[index] == min){
                    console.log("Two equal T values at "+min+" "+ somearray[index]);
                }
                minIndex = index;
                min = somearray[index];
            }
            
        }
    }
    return minIndex;
}

function getIntersectTime(distance, speed){
    return distance/speed;
}

function minkowskiRect(A,B){
    var m = {x1:0,y1:0,x2:0,y2:0}
    m.x1 = B.x1 - (A.width -1);
    m.y1 = B.y1 - (A.height -1);
    m.x2 = B.x2;
    m.y2 = B.y2;
    return m;
}

function getCollisions(){
    collision = "none";
    var baseTime = 0;
    //console.log("getCollisions called");
    
    //Two iterations, because after hitting a wall from horizontal movement
    //There's still a vertical component that needs to be evaluated
    //More iterations are possible, but not necessary if all objects use rectangular bounding boxes
    //Typically, it would run several (3-4) iterations, or until baseTime == 1.00
    //Ensures player cannot pass through walls, regardless of velocity and size.
    for (var i = 0; i < 2; i++){
        var x3 = playerObj.X;
        var x4 = playerObj.X+playerObj.width-1;
        var y3 = playerObj.Y;
        var y4 = playerObj.Y+playerObj.height-1;
        
        var Xv = Math.round(playerObj.Xv);
        var Yv = Math.round(playerObj.Yv);
        //Adjust AABB for preliminary collision checking
        if (Xv > 0){
             x4 += Xv;
        }
        else if (Xv < 0){
             x3 += Xv;
        }
    
        if (Yv > 0){
             y4 += Yv;
        }
        else if (Yv < 0){
             y3 += Yv;
        }
        
        //Get a list of all walls that *could* be colliding with the player object
        var selectedWalls = [];
        for (var wall of walls){
            //console.log("evaluating wall id "+wall.id);
            //var collisions = [];
            var x1 = wall.x1;
            var y1 = wall.y1;
            var x2 = wall.x2;
            var y2 = wall.y2;
            
            if (x1 <= x4 && x2 >= x3
            &&  y1 <= y4 && y2 >= y3){
                selectedWalls.push(wall);
                //$("#"+wall.id).css("background-color","red");
            //}
            //else{
                //$("#"+wall.id).css("background-color","white");
            }
     
        }
        
        var timeVal = [];
        var timeValAdj = [];
        //var 
        var collisionType = [];
        var t;
        
        //Iterate through all walls selected as "potentially colliding"
        //use the more accurate/expensive check to determine if there is a collision
        //and any additional information
        for (var wall of selectedWalls){
            var m = minkowskiRect(playerObj, wall);
            var x1 = m.x1;
            var y1 = m.y1;
            var x2 = m.x2;
            var y2 = m.y2;
            
            if (playerObj.Xv != 0){
                t = (x1-playerObj.X)/Xv;
                var intersectY = playerObj.Y + (1-baseTime)*t*Yv;
                if (intersectY >= y1 && intersectY <= y2){
                    timeVal.push(t)
                    t = (x1-playerObj.X-1)/Xv;
                    timeValAdj.push(t);
                    collisionType.push("h");
                }
                t = (x2-playerObj.X)/Xv;
                intersectY = playerObj.Y + (1-baseTime)*t*Yv;
                if (intersectY >= y1 && intersectY <= y2){
                    timeVal.push(t);
                    t = (x2-playerObj.X+1)/Xv;
                    timeValAdj.push(t);
                    collisionType.push("h");
                }
                
            }
            
            
            if (playerObj.Yv != 0){
                t = (y1-playerObj.Y)/Yv;
                var intersectX = playerObj.X + (1-baseTime)*t*Xv;
                if (intersectX >= x1 && intersectX <= x2){
                    timeVal.push(t);
                    t = (y1-playerObj.Y-1)/Yv;
                    timeValAdj.push(t);
                    collisionType.push("v");
                }
                t = (y2-playerObj.Y)/Yv;
                intersectX = playerObj.X + (1-baseTime)*t*Xv;
                if (intersectX >= x1 && intersectX <= x2){
                    timeVal.push(t);
                    t = (y2-playerObj.Y+1)/Yv;
                    timeValAdj.push(t);
                    collisionType.push("v");
                }
            }
            
        }
        
        var index = getIndexOfSmallestValidTime(timeVal);
        //Evaluate "first" collision, i.e. the collision with the lowest time value from 0-1.
        if (index != -1){
            
            //timeVal Will place object at collision point, which means inside the object, overlapping by 1 pixel
            //So we use timeValAdj, which has the same math, but with an offset wall boundary
            t = timeValAdj[index];

            playerObj.X = Math.round(playerObj.X+(1-baseTime)*t*Xv);
            playerObj.Y = Math.round(playerObj.Y+(1-baseTime)*t*Yv);
            
            baseTime += (1-baseTime)*t;
            if (collisionType[index] == "h"){
                //Collision from horizontal movement first detected
                collision = "horizontal";
                playerObj.Xv = 0;
            }
            if (collisionType[index] == "v"){
                //Collision from vertical movement first detected
                collision = "vertical";
                playerObj.Yv = 0;
            }
            
        }
        //No collisions this iteration
        else{
            playerObj.X = playerObj.X + (1-baseTime)*Xv;
            playerObj.Y = playerObj.Y + (1-baseTime)*Yv;
            break;
        }
    }
    
    //Rounds X and Y positions to integers, because it's nicer to the collision detection algorithm
    playerObj.X = Math.round(playerObj.X);
    playerObj.Y = Math.round(playerObj.Y);
    
    //Clears and updates the standingOn and nextTo arrays of the player
    playerObj.standingOn.length = 0;
    playerObj.nextTo.length = 0;
    
    //Determine which walls the player is standing on, or next to, and store for
    //later use
    for (var wall of walls){
        x1 = wall.x1;
        y1 = wall.y1;
        x2 = wall.x2;
        y2 = wall.y2;
        
        //One pixel away from the bottom of the player.
        x3 = playerObj.X;
        x4 = playerObj.X+playerObj.width-1;
        y3 = playerObj.Y;
        y4 = playerObj.Y+playerObj.height;
        
        if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
            playerObj.standingOn.push(wall)
        }
        
        //One pixel left/right of the player
        x3 = playerObj.X;
        x4 = playerObj.X+playerObj.width;
        y3 = playerObj.Y;
        y4 = playerObj.Y+playerObj.height-1;
        
        if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
            playerObj.nextTo.push(wall);
        }
    }
    
    //Determine collision for level exit.
    
    x1 = exit.X;
    y1 = exit.Y;
    x2 = exit.X + exit.width-1;
    y2 = exit.Y + exit.height-1;
    //console.log("y2: "+y2);
    x3 = playerObj.X;
    x4 = playerObj.X+playerObj.width-1;
    y3 = playerObj.Y;
    y4 = playerObj.Y+playerObj.height-1;
    
    if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
        //console.log("Exit touched");
        currentstage++;
        currentstage = currentstage%stages.length;
        loadLevel(stages[currentstage]);
    }
    
    
    
}

function init(){
    gameTimer = setInterval(mainLoop, 1000/tickFreq)
    gameWindow = $("#gameWindow");
    //Create player
    playerObj = {'X':-99999,'Y':0,'Xv':0,'Yv':0,'width':32,'height':32,'standingOn':[],'nextTo':[],wantsWallJump:0};
    gameWindow.append("<img id='Player' class='object' src='img/transparent.gif'>");
    playerObj.element = $("#Player");
    playerObj.element.css("left",playerObj.X+"px");
    playerObj.element.css("top",playerObj.Y+"px");
    playerObj.element.css("width",playerObj.width+"px");
    playerObj.element.css("height",playerObj.height+"px");
    playerObj.element.css("visibility","visible");
    playerObj.Walljumping = 0;
    debugInfo = $("#debugInfo");
    spawn = initSpawn();
    exit = initExit();
    exit.element.css("visibility","visible");
    exit.element.css("left",exit.X+"px");
    exit.element.css("top",exit.Y+"px");
    initInputs();
    currentstage = 0;
    stages = [];

    stages.push("d2WB3WB9W82WU2Wr3WJ6WJ4WG1Wh6WCAWI7Wc8Wr3W2AW87Wx-VN1WF1WI7Wx-Vu-VQAWU1Wt0WS1WQAWH7WD1WS5WX2Wh6Wy2WAxV33WNzVy2W7yVH4WEyVE4W0xVM4WQzV65WHxVN5WZxV65W2yVQ5WSzV");
    stages.push("Z2Wr5WQ7WlyVv1Wx6W86WJ8W01Wg4W-3WK5W86WP+V47WJ8We3WfyVS4WK5We3W+xV09WgyV39W+xVi9WT+V86WP+Vi9W2-V01WB5Wx1WJ8W");
    stages.push("d8WF2W1EW+4WS6WH-V27W37W27Wb6WYDW37W7DWa6W2GW37W5AWa-VGAWz1W-AW+2WLDWS4WS6Wu+VrGWe-VQ8W+2WK0WW4W1GW6-VrGW37WQ8WQ4Wg8WG5WdCWN4WLDWt6W");
    stages.push("76Wy5WYBWn4Wi4WS5WG5W29WG5WX8WWAW29WWAWP6WVEW+6W76WU6WY6WV7WWAWT6WzAW29Wi4Wi3WD6WX5W");

    loadLevel(stages[0]);
}

function mainLoop(){

    //evaluate player movement
    var X = playerObj.X;
    var Xv = playerObj.Xv;
    var Y = playerObj.Y;
    var Yv = playerObj.Yv;

    //Gravity
    playerObj.Yv += 3.0;
    
    //Key inputs
    
    //When Z is pressed, but not when held
    if (keystates[0] && prevkeystates[0] == false){
        //Check if a wall is under the player
        if (playerObj.standingOn.length != 0){
            playerObj.Yv = -20.0
            console.log("Jump successful");
        }
        else{//check if the player is holding a direction key
            //wall on left, jump to the right
            if (keystates[2] || keystates[4]){
                playerObj.wantsWallJump = 3; //for 3 ticks, player will walljump automatically if conditions are met
            }
        }
        
    }
    
    //walljumping buffered
    if (keystates[2] && playerObj.wantsWallJump > 0 && wallAdjacent(playerObj,"left") && playerObj.Walljumping == 0){
        playerObj.Yv = -17.0
        playerObj.Xv = 20.0
        //Walljumping disables arrow momentum for 4 game ticks.
        playerObj.Walljumping = 4;
    }
    //wall on right, jump to the left
    if (keystates[4] && playerObj.wantsWallJump > 0 && wallAdjacent(playerObj,"right") && playerObj.Walljumping == 0){
        playerObj.Yv = -17.0
        playerObj.Xv = -20.0
        //Walljumping disables arrow momentum for 4 game ticks.
        playerObj.Walljumping = 4;
    }
    
    
    
    //When Z is held
    if (keystates[0]){
        //If player is rising, counteract gravity while jump is held to create
        //a "high jump"
        if (playerObj.Yv < 0){
            playerObj.Yv += -1.8;
        }
    }
    
    //left
    if (keystates[2] && playerObj.Walljumping == 0){
        playerObj.Xv += -2.2
    }
    //right
    if (keystates[4] && playerObj.Walljumping == 0){
        playerObj.Xv += 2.2
    }
    
    if (playerObj.Walljumping > 0){
        playerObj.Walljumping--;
    }
        
    if (playerObj.wantsWallJump > 0){
        playerObj.wantsWallJump--;
    }
    
    /*
    //up
    if (keystates[3]){
        playerObj.Yv += -3.0
    }
    //down
    if (keystates[5]){
        playerObj.Yv += 3.0
    }
    */
    
    playerObj.Xv = playerObj.Xv*0.89;
    playerObj.Yv = playerObj.Yv*0.91;
    if (playerObj.Xv*playerObj.Xv < .1){
        playerObj.Xv = 0;
    }
    if (playerObj.Yv*playerObj.Yv < .1){
        playerObj.Yv = 0;
    } 

    
    getCollisions();
    updateCameraPosition();
    updateImgPositions();

    prevkeystates = keystates.slice();
    //Display keystates in the debug menu
    debugInfo.empty();
    for (var index in keystates){
        debugInfo.append(indexToChar[index]+": "+keystates[index]+"<br/>");
    }
    debugInfo.append("X: "+playerObj.X+"<br/>");
    debugInfo.append("Y: "+playerObj.Y+"<br/>");
    debugInfo.append("Xv: "+playerObj.Xv+"<br/>");
    debugInfo.append("Yv: "+playerObj.Yv+"<br/>");
    debugInfo.append("Collision: "+collision+"<br//");
    //$("#debugInfo").append("CanWallJump: "+canwalljump+"<br//");
}

function movePlayer(X,Y){
    playerObj.X = X;
    playerObj.Y = Y;
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
    
    playerObj.X = spawn.X;
    playerObj.Y = spawn.Y;
    
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
}

function encodeInt(val){
    console.log("encoding value "+val);
    maxlength = 3;
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

//Program starting point, creates global variables, and initializes them
var maxlength = 3;
var alphabet = ("1234567890ABCDEFGHIJKLMNOPQWSTUVWXYZabcdefghijklmnopqrstuvwxyz+-");
var alphabetmap;
initAlphabetMap();

var tickFreq = 30 //number of updates per second
var gameTimer;
var keyToIndex = {"90":0, "88":1, "37":2, "38":3, "39":4, "40":5}
var indexToChar = ["z","x","left", "up", "right","down"];
//z, x, left, up, right, down
var keystates = [false,false,false,false,false,false];
//used to detect single presses
var prevkeystates = [false,false,false,false,false,false];
var playerObj
var enemies = [];
var walls = [];
var exit;
var collision = "none";
var camera = {X:0,Y:0};
var spawn;
var gameWindow;
var debugInfo;
var spawn;
var currentstage;
var stages;

window.onload = init();