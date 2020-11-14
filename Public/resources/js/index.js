//Moment
var moment = require("moment");

//Time AND Date
var myDate = new Date();

//Date MM/DD/YY
var myDateNow = moment(myDate).format("L");
//Time 12:00 PM
var myTimeNow = moment(myDate).format("LT");
//Date MM,DD YY
var myDateNow1 = moment(myDate).format("LL"); 


