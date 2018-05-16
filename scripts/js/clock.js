function theClock()
{
    var currentTime = new Date();
    document.getElementsByTagName('header')[0].innerHTML = currentTime.getHours() + ':' + currentTime.getMinutes() + '.' + currentTime.getSeconds();
}

