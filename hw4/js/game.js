function updateImgPositions(){
    $("#Player").css("left",Math.round(playerObj.X-camera.X));
    $("#Player").css("top",Math.round(playerObj.Y-camera.Y));
    
    for (var wall of walls){
        //console.log("Updating position of wall "+wall.id);
        $("#"+wall.id).css("left",Math.round(wall.x1-camera.X));
        $("#"+wall.id).css("top",Math.round(wall.y1-camera.Y));
    }
    
    $("#exit").css("left",Math.round(exit.x1-camera.X));
    $("#exit").css("top",Math.round(exit.y1-camera.Y));
}

function updateUI(){
    
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
    var height = bottom-top;
    var width = right-left;
    var wall = {id:wallid, x1:left, y1:top, x2:right, y2:bottom};
    walls.push(wall);
    
    $("#gameWindow").append("<img id='" + wallid + "' class='object' src='img/transparent.gif' height='"+ height +"' width='"+ width +"'>");
    $("#"+wallid).css("left",left);
    $("#"+wallid).css("top",top);
    $("#"+wallid).css("background-color","white");
    console.log("Wall created: "+wall.id+","+wall.x1+","+wall.y1+","+wall.x2+","+wall.y2);
}

function clearWalls(){
    for (var wall of walls){
        $("#"+wall.id).remove();
    }
    walls.length = 0;
}
    
function wallAdjacent(obj,direction){
    for (var wall of walls){
        if (wall.x2 == obj.X && direction == "left"){
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
            if (somearray[index] < min){
                minIndex = index;
                min = somearray[index];
            }
        }
    }
    return minIndex;
}

function minkowskiRect(A,B){
    var m = {x1:0,y1:0,x2:0,y2:0}
    m.x1 = B.x1 - A.width;
    m.y1 = B.y1 - A.height;
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
    for (var i = 0; i < 3; i++){
        var x3 = playerObj.X+1;
        var x4 = playerObj.X+playerObj.width-1;
        var y3 = playerObj.Y+1;
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
            
            //if so, then use the more accurate/expensive check to determine if there is a collision
            //and any additional information
            if (x1 <= x4 && x2 >= x3
            &&  y1 <= y4 && y2 >= y3){
                selectedWalls.push(wall);
                //$("#"+wall.id).css("background-color","red");
            }
            //else{
                //$("#"+wall.id).css("background-color","white");
            //}
     
        }
        
        var timeVal = [];
        var collisionType = [];
        var t;
        
        //Iterate through all walls selected as "potentially colliding"
        for (var wall of selectedWalls){
            var m = minkowskiRect(playerObj, wall);
            var x1 = m.x1;
            var y1 = m.y1;
            var x2 = m.x2;
            var y2 = m.y2;
            
            if (playerObj.Xv != 0){
                timeVal.push((x1-playerObj.X)/Xv)
                collisionType.push("h");
                timeVal.push((x2-playerObj.X)/Xv)
                collisionType.push("h");
            }
            
            
            if (playerObj.Yv != 0){
                timeVal.push((y1-playerObj.Y)/Yv)
                collisionType.push("v");
                timeVal.push((y2-playerObj.Y)/Yv)
                collisionType.push("v");
            }
            
        }
        
        var index = getIndexOfSmallestValidTime(timeVal);
        //Evaluate "first" collision, i.e. the collision with the lowest time value from 0-1.
        if (index != -1){
            t = timeVal[index];
            
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
        x3 = playerObj.X+1;
        x4 = playerObj.X+playerObj.width-1;
        y3 = playerObj.Y+1;
        y4 = playerObj.Y+playerObj.height;
        
        if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
            playerObj.standingOn.push(wall)
        }
        
        //One pixel left/right of the player
        x3 = playerObj.X;
        x4 = playerObj.X+playerObj.width;
        y3 = playerObj.Y+1;
        y4 = playerObj.Y+playerObj.height-1;
        
        if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
            playerObj.nextTo.push(wall);
        }
    }
    
    //Determine collision for level exit.
    
    x1 = exit.x1;
    y1 = exit.y1;
    x2 = exit.x2;
    y2 = exit.y2;

    x3 = playerObj.X+1;
    x4 = playerObj.X+playerObj.width-1;
    y3 = playerObj.Y+1;
    y4 = playerObj.Y+playerObj.height-1;
    
    if (x1 <= x4 && x2 >= x3
        &&  y1 <= y4 && y2 >= y3){
        exit.stagefunc();
    }
        
    
    
}


function mainLoop(){

    //evaluate player movement
    var X = playerObj.X;
    var Xv = playerObj.Xv;
    var Y = playerObj.Y;
    var Yv = playerObj.Yv;

    //Gravity
    playerObj.Yv += 2.5;
    
    //Key inputs
    
    //When Z is pressed, but not when held
    if (keystates[0] && prevkeystates[0] == false){
        //Check if a wall is under the player
        if (playerObj.standingOn.length != 0){
            playerObj.Yv = -20.0
            console.log("Jump successful");
        }
        else{
            //wall on left, jump to the right
            if (keystates[2] && wallAdjacent(playerObj,"left")){
                playerObj.Yv = -15.0
                playerObj.Xv = 20.0
                //Walljumping disables arrow momentum for 4 game ticks.
                playerObj.Walljumping = 4;
            }
            //wall on right, jump to the left
            if (keystates[4] && wallAdjacent(playerObj,"right")){
                playerObj.Yv = -15.0
                playerObj.Xv = -20.0
                playerObj.Walljumping = 4;
            }
        }


        //Check if jump and an arrow key is pressed.
        //left

        

    
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
        playerObj.Xv += -2.4
    }
    //right
    if (keystates[4] && playerObj.Walljumping == 0){
        playerObj.Xv += 2.4
    }
    
    if (playerObj.Walljumping > 0){
        playerObj.Walljumping--;
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
    
    playerObj.Xv = playerObj.Xv*0.85;
    playerObj.Yv = playerObj.Yv*0.85;
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
    $("#debugInfo").empty();
    for (var index in keystates){
        $("#debugInfo").append(indexToChar[index]+": "+keystates[index]+"<br/>");
    }
    $("#debugInfo").append("X: "+playerObj.X+"<br/>");
    $("#debugInfo").append("Y: "+playerObj.Y+"<br/>");
    $("#debugInfo").append("Xv: "+playerObj.Xv+"<br/>");
    $("#debugInfo").append("Yv: "+playerObj.Yv+"<br/>");
    $("#debugInfo").append("Collision: "+collision+"<br//");
    //$("#debugInfo").append("CanWallJump: "+canwalljump+"<br//");
}

function placeExit(X,Y, func){

    exit.x1 = X;
    exit.y1 = Y;
    exit.x2 = X+96;
    exit.y2 = Y+96;
    exit.stagefunc = func;
}

function movePlayer(X,Y){
    playerObj.X = X;
    playerObj.Y = Y;
}

function initStage1(){
    clearWalls();
    movePlayer(100,100);
    createWall(0,0,1600,1);
    createWall(0,799,1600,800);
    
    createWall(0,0,1,800);
    createWall(1599,0,1600,800);

    createWall(0,275,1300,276);
    
    createWall(375,250,475,325);
    
    createWall(575,200,675,325);
    placeExit(1200,180, initStage2);
}

function initStage2(){
    clearWalls();
    movePlayer(100,100);
    createWall(0,0,1600,1);
    createWall(0,799,1600,800);
    
    createWall(0,0,1,800);
    createWall(1599,0,1600,800);

    createWall(0,275,1300,276);
    
    createWall(375,100,400,325);
    
    createWall(265,0,290,200);
    
    placeExit(1200,180, initStage3);
}

function initStage3(){
    clearWalls();
    movePlayer(100,100);
    createWall(0,0,1600,1);
    createWall(0,799,1600,800);
    
    createWall(0,0,1,800);
    createWall(1599,0,1600,800);

    createWall(0,500,1600,501);
    
    createWall(400,425,425,450);
    for (var i = 1; i < 4; i++){
        createWall(400+25*i,450-50*i,425+25*i,450);
    }
    
    for (var i = 0; i < 7; i++){
        createWall(600+125*i,275,650+125*i,300);
    }
    createWall(1400,275,1600,276);
    
    //createWall(265,0,290,200);
    
    placeExit(1500,180, initStage1);
}


//Program starting point, creates global variables, and initializes them
var tickFreq = 30 //number of updates per second
var gameTimer = setInterval(mainLoop, 1000/tickFreq);
var keyToIndex = {"90":0, "88":1, "37":2, "38":3, "39":4, "40":5}
var indexToChar = ["z","x","left", "up", "right","down"];
//z, x, left, up, right, down
var keystates = [false,false,false,false,false,false];
//used to detect single presses
var prevkeystates = [false,false,false,false,false,false];
var playerObj = {'imgId': "Player", 'X':0,'Y':0,'Xv':0,'Yv':0,'width':32,'height':32,'standingOn':[],'nextTo':[]};
var enemies = [];
var walls = [];
var exit = {};
var collision = "none";
var camera = {X:0,Y:0};

//Create player
$("#gameWindow").append("<img id='Player' class='object' src='img/transparent.gif'>");
$("#Player").css("width","32px");
$("#Player").css("height","32px");
playerObj.Walljumping = 0;

//Create exit img
$("#gameWindow").append("<img id='exit' class='object' src='img/exit.png' height='96' width='96'>");

initInputs();

initStage1();