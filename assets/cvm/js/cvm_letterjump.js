 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
    let loadJumpLetters = function()
    {
        let jumpLettersList = document.querySelectorAll(".jumpLetters");
        for (let i = jumpLettersList.length - 1; i >= 0; i--)
        {
            let content = jumpLettersList[i].textContent;
            jumpLettersList[i].textContent = "";
            for (let j = content.length - 1; j >= 0; j--)
            {
                jumpLettersList[i].innerHTML += "<span>" + content.substr(0, 1) + "</span>";
                content = content.substr(1, content.length - 1);
            }
            let lettersList = jumpLettersList[i].querySelectorAll("span");
            for (let j = lettersList.length - 1; j >= 0; j--)
            {
                lettersList[j].addEventListener("mouseover", function(event)
                {
                    event.target.style.fontWeight = "bold";
                    event.target.style.fontStyle = "italic";
                    event.target.style.color = "red";
                    event.target.style.cursor = "pointer";
                }, false);
                lettersList[j].addEventListener("mouseout", function(event)
                {
                    event.target.style = "";
                }, false);
            }
        }
    }
    loadJumpLetters();
});