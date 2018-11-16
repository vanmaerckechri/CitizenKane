 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
    let launchConsoleWrite = function(container, content)
    {
        container.textContent = "";
        container.classList.remove("displayNone");
        let indexLetter = 0;
        let interval = setInterval (function()
        {
            container.textContent += content[indexLetter];
            indexLetter += 1; 
            if (content.length - 1 == indexLetter)
            {
                clearInterval(interval);
            }
        }, 33);
    }

    // for example =>
    let consoleWriteExample01 = document.getElementById("consoleWriteExample01");
    let consoleWriteExample02 = document.getElementById("consoleWriteExample02");

    let consoleWriteExample01Content = consoleWriteExample01.textContent;
    let consoleWriteExample02Content = consoleWriteExample02.textContent;

    launchConsoleWrite(consoleWriteExample01, consoleWriteExample01Content);
    let timeBeforeLaunch = setTimeout (function()
    {
        launchConsoleWrite(consoleWriteExample02, consoleWriteExample02Content);
    }, 2000);
});

/*
    need base.scss for "displayNone" class
*/