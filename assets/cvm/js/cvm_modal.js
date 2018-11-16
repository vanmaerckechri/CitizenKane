 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
	let modalButtonList = document.querySelectorAll(".modal-btn");
	let btnLength = modalButtonList.length;
	let modalContainerList = document.querySelectorAll(".modal-container");
	let ctrLength = modalContainerList.length;
	// link button(s) to container(s)
	for (let i = btnLength - 1; i >= 0; i--)
	{
		// check if modal button has a class that start with "target_"
		for (let j = modalButtonList[i]["classList"].length - 1; j >= 0; j--)
		{
			let className = modalButtonList[i]["classList"][j];
			if (className.indexOf("target_") != -1)
			{
				// get modal container by id from part of the class button
				let idModalCtr = className.slice(7, className.length);
				let modalContainer = document.getElementById(idModalCtr);
				if (modalContainer.classList.contains("modal-container"))
				{
					// open/close button
					modalButtonList[i].addEventListener("click", function()
					{
						modalContainer.classList.toggle("hidden");
					}, false);
				}
				break;
			}
		}
	}
	// close (if click outside content)
	for (let i = ctrLength - 1; i >= 0; i--)
	{
		modalContainerList[i].addEventListener("click", function(event)
		{
			if (modalContainerList[i] == event.target)
			{
				modalContainerList[i].classList.toggle("hidden");
			}
		}, false);
	}
});

/* 	
	(sass: "assets/cvm/sass/_modal.scss")

	HTML:

	<link rel="stylesheet" href="assets/cvm/css/cvm_style.css">

    <div id="name01" class="modal-container hidden">
		...
    </div>
    <button id="modal-btn" class="modal-btn target_name01">open</button>

    <script type="text/javascript" src="assets/cvm/js/cvm_modal.js"></script>
*/


