 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
	let viewContentList = document.querySelectorAll(".view-content");
	let viewLength = viewContentList.length;
	// import Html content function: "content" = DOMObject to welcome view file content; "fileName" = part of view file name.
	let importHtmlContent = function(content, fileName)
	{      
		const req = new XMLHttpRequest();
        req.onreadystatechange = function(event)
        {
            if (this.readyState === XMLHttpRequest.DONE)
            {
                if (this.status === 200)
                {
                    content.innerHTML = req.responseText;
                }
            }
        };
        req.open('GET', 'views/view_'+fileName+'.html', true);
        req.send(null);
    }
	// loop of the contents list to import the view
	for (let i = viewLength - 1; i >= 0; i--)
	{
		let idContent = viewContentList[i].id;
		let viewContainer = document.getElementById(idContent);
		importHtmlContent(viewContainer, idContent);
	}
});

/* 	
	HTML:

    <p id="test01" class="view-content"></p>

    <script type="text/javascript" src="assets/cvm/js/cvm_view.js"></script>
*/


