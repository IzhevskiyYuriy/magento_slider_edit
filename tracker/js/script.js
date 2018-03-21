const path = "http://dockerized-magento.local/tracker/query.php";
const method = "post";

var parse = function(ua, platform){
    ua = ua.toLowerCase();
    platform = (platform ? platform.toLowerCase() : '');
    // chrome is included in the edge UA, so need to check for edge first,
    // before checking if it's chrome.
    var UA = ua.match(/(edge)[\s\/:]([\w\d\.]+)/);
    if (!UA){
        UA = ua.match(/(opera|ie|firefox|chrome|trident|crios|version)[\s\/:]([\w\d\.]+)?.*?(safari|(?:rv[\s\/:]|version[\s\/:])([\w\d\.]+)|$)/) || [null, 'unknown', 0];
    }
    if (UA[1] == 'trident'){
        UA[1] = 'ie';
        if (UA[4]) UA[2] = UA[4];
    } else if (UA[1] == 'crios'){
        UA[1] = 'chrome';
    }
    platform = ua.match(/ip(?:ad|od|hone)/) ? 'ios' : (ua.match(/(?:webos|android)/) || ua.match(/mac|win|linux/) || ['other'])[0];
    if (platform == 'win') platform = 'windows';
    return {
        name: (UA[1] == 'version') ? UA[3] : UA[1],
        version: parseFloat((UA[1] == 'opera' && UA[4]) ? UA[4] : UA[2]),
        platform: platform
    };
};
function setCookie (name, value,  path, domain, secure) {
    var  expires = new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000);
    return document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
var guidGenerator = function () {
    var S4 = function() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+S4()+S4()+S4()+S4()+S4()+S4());
}
function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);//вернет -1 если имя не найдено
        if (offset !== -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}

function checkCookie() {
    if (getCookie('track') !== null) {
        return getCookie('track')
    } else {
        setCookie("track", guidGenerator(), "/");
    }
}

function getXmlHttp(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function createAjax(path, method, Browser){
    var xhr = getXmlHttp();
    xhr.open(path, method, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange=function()
    {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            if (xhr.responseText != null) {
                document.getElementById('info').innerHTML = xhr.responseText;
            }
            else alert('Ощибка Ajax:' + this, xhr.statusText);
        } else {
            return ;
        }
    }
    xhr.send('param=' + JSON.stringify(Browser));
}

checkCookie();
var Browser = {};
Browser.open = "";
Browser.userAgent = parse(navigator.userAgent);
Browser.Cookie = getCookie('track');
window.onload = function () {
    Browser.open = location;
    if (Browser.open && getCookie('track') !== null) {
        createAjax(method, path,  Browser)

    }

};