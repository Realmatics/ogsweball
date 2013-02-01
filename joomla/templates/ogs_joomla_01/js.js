// Logonew



function changelogonew()
{

		document.getElementById('logonew').src="http://opengeosys.org/images/OpenGeoSys7.png";
	
}

function changelogonew1()
{
		document.getElementById('logonew').src="http://opengeosys.org/images/OpenGeoSys.png";	
}


function Tastendruck (Ereignis) {
  if (!Ereignis)
    Ereignis = window.event;
  if (Ereignis.button) {
    if (Ereignis.button == 1) {
      //alert("Linke Maustaste gedrückt");
    } else {
      //alert("Andere Maustaste gedrückt");
	document.getElementById('logonew').src="http://opengeosys.org/images/OpenGeoSys.png";
    }
  }
}

document.onmousedown = Tastendruck;
// Ende Logonew



/*
// THMC
function showInfo()
{
  document.getElementById('hoverthermo').style.visibility = "visible";
}

function showInfo1()
{
  document.getElementById('hoverhydro').style.visibility = "visible";
}

function showInfo2()
{
  document.getElementById('hovermechanical').style.visibility = "visible";
}

function showInfo3()
{
  document.getElementById('hoverchemical').style.visibility = "visible";
}

function clearInfo()
{
  document.getElementById('hoverthermo').style.visibility = "hidden";
  document.getElementById('hoverhydro').style.visibility = "hidden";
  document.getElementById('hovermechanical').style.visibility = "hidden";
  document.getElementById('hoverchemical').style.visibility = "hidden";
}
// Ende THMC */ 

// Browsererkennung
var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1) fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1) fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}

//alert(browserName);
// Ende Browsererkennung

// RSS nur bei Firefox

//alert('test');alert(browserName);

function onload()
{
//if(browserName != "Firefox")
//{
//alert(browserName);
document.getElementById('showrss').style.visibility = "hidden";
//}
}


function addClass (element, className) {
    if (!hasClass(element, className)) {
        if (element.className) {
            element.className += " " + className;
        } else {
            element.className = className;
        }
    }
}

function removeClass (element, className) {
var regexp = addClass[className];
    if (!regexp) {
        regexp = addClass[className] = new RegExp("(^|\\s)" + className + "(\\s|$)");
    }
    element.className = element.className.replace(regexp, "$2");
}

function hasClass (element, className) {
    var regexp = addClass[className];
    if (!regexp) {
        regexp = addClass[className] = new RegExp("(^|\\s)" + className + "(\\s|$)");
    }
    return regexp.test(element.className);
}

function toggleClass (element, className) {
    if (element.hasClass(className)) {
        element.removeClass(className);
    } else {
        element.addClass(className);
    }
}



function changeClassProperties(name) {
	var Ergebnis1 = nAgt.search(/Opera Mini.+/);	
	if (Ergebnis1 != -1) {
	// Array enthält alle Elemente des Dokuments
	var obj = document.getElementsByTagName("*");
	
	// Schleife durchläuft Element-Array
	for (var i=0; i<obj.length; i++) {
		/* Überprüft ob der Klassenname des aktuellen Elements
		mit dem übergebenen Parameter übereinstimmt */
		var Ergebnis = obj[i].className.search(name);
		if (Ergebnis != -1) {
			with ( obj[i] ) {				
				//style.visibility = "visible";
			}
		}
	}
}
}
 
