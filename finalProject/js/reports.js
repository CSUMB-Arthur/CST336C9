$("#studentsShowButton").click(function(){
    $("#studentsShowButton").hide();
    $("#studentsHideButton").show()
    $("#number").show();
});


$("#studentsHideButton").click(function(){
    $("#studentsShowButton").show();
    $("#studentsHideButton").hide()
    $("#number").hide();
});

$("#costShowButton").click(function(){
    $("#costShowButton").hide();
    $("#costHideButton").show()
    $("#cost").show();
});


$("#costHideButton").click(function(){
    $("#costShowButton").show();
    $("#costHideButton").hide()
    $("#cost").hide();
});


$("#dateShowButton").click(function(){
    $("#dateShowButton").hide();
    $("#dateHideButton").show()
    $("#latest").show();
});


$("#dateHideButton").click(function(){
    $("#dateShowButton").show();
    $("#dateHideButton").hide()
    $("#latest").hide();
});


$("#countShowButton").click(function(){
    $("#countShowButton").hide();
    $("#countHideButton").show()
    $("#classCount").show();
});


$("#countHideButton").click(function(){
    $("#countShowButton").show();
    $("#countHideButton").hide()
    $("#classCount").hide();
});