 "use strict";

let updatePlats = {};
let updatePlatsOrder = {};
let updateCarteImageNewImages = {};
let updateCarteImageCartesId = [];
let updateCartesTitle = {};

window.addEventListener("load", function(event)
{
	let checkObjectEmpty = function(object)
	{
		let result = false;
		for (let property in object)
		{
			result = true;
		}
		return result;
	}

	let recordChanges = function()
	{
		let formAction = "index.php?action=" + page;
		let form = createElem(["form"], [["action", "method", "enctype"]], [[formAction, "post", "multipart/form-data"]]);

		if (checkObjectEmpty(updateCarteImageNewImages) === true)
		{
			for (let propertyTitle in updateCarteImageNewImages)
			{
				let newImg = updateCarteImageNewImages[propertyTitle];
				updateCarteImageCartesId.push(propertyTitle);
				form.appendChild(newImg);
			}
			updateCarteImageCartesId = JSON.stringify(updateCarteImageCartesId);
			let cartesId = createElem(["input"], [["type", "value", "name"]], [["text", updateCarteImageCartesId, "updateCarteImageCartesId"]]);
			form.appendChild(cartesId);
		}

		if (checkObjectEmpty(updateCartesTitle) === true)
		{
			updateCartesTitle = JSON.stringify(updateCartesTitle);
			let cartesTitle = createElem(["input"], [["type", "value", "name"]], [["text", updateCartesTitle, "updateCartesTitle"]]);
			form.appendChild(cartesTitle);
		}

		if (checkObjectEmpty(updatePlats) === true)
		{
			updatePlats = JSON.stringify(updatePlats);
			let plats = createElem(["input"], [["type", "value", "name"]], [["text", updatePlats, "updatePlats"]]);
			form.appendChild(plats);
		}

		if (checkObjectEmpty(updatePlatsOrder) === true)
		{
			updatePlatsOrder = JSON.stringify(updatePlatsOrder);
			let platsOrder = createElem(["input"], [["type", "value", "name"]], [["text", updatePlatsOrder, "updatePlatsOrder"]]);
			form.appendChild(platsOrder);
		}

		if (checkObjectEmpty(updateCarteImageNewImages) === true || checkObjectEmpty(updateCartesTitle) === true || checkObjectEmpty(updatePlats) === true || checkObjectEmpty(updatePlatsOrder) === true)
		{
			document.body.appendChild(form);
			form.submit();
		}
	}

	let updateCarteImg = function(event)
	{
		let idCarte = event.target.id.slice(10, event.target.id.length);
		updateCarteImageNewImages[idCarte] = (event.target);
	}

	let updateCarteTitle = function(item)
	{
		let id = item.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);

		updateCartesTitle[id] = item.value;

		console.log(updateCartesTitle)
	}

	let updatePlat = function(item, platPropery)
	{
		let idPlat = item.parentNode.id;
		let index = idPlat.indexOf("__");
		idPlat = idPlat.slice(index + 2, idPlat.length);

		updatePlats[idPlat] = !updatePlats[idPlat] ? {} : updatePlats[idPlat];
		updatePlats[idPlat][platPropery] = item.value;
	}

	let moveOrder = function(event)
	{
		let li = event.target.parentNode;
		let liBrother;
		let ul = li.parentNode;
		let oldMouseY = 0;
		li.style.border = "1px solid grey";

		let saveNewOrder = function(li, liBrother)
		{
			let ul = li.parentNode;
			let ulId = ul.id;
			ulId = ulId.slice(7, ulId.length);
			let liList = ul.querySelectorAll("li");

			// create skeleton of carte after first move
			if (!updatePlatsOrder[ulId])
			{
				updatePlatsOrder[ulId] = {};
    		}

			for (let i = liList.length - 1; i >= 0; i--)
			{
				let id = liList[i].id;
				let idPlatsExist = id.indexOf("plats__");
				if (idPlatsExist != -1)
				{
					id = id.slice(7, id.length);
					updatePlatsOrder[ulId][i] = parseInt(id, 10);
				}
			}
		}

		let detectMouseDirection = function(mouseY)
		{
			let result = "top";
			if (mouseY > oldMouseY)
			{
				result = "bot";
			}
			oldMouseY = mouseY;
			return result;
		}
		document.body.onmousemove = function(event)
		{
			let mouseY = event.clientY;
			ul.onmouseover = function(event)
			{
				if (event.target.nodeName == "LI")
				{
					if (detectMouseDirection(mouseY) == "top")
					{
						liBrother = event.target;
						ul.insertBefore(li, liBrother)
					}
					else
					{
						liBrother = event.target.nextSibling;
						ul.insertBefore(li, liBrother)
					}
				}
			}
		}
		document.body.onmouseup = function()
		{
			saveNewOrder(li, liBrother);
			li.style = "";
			document.body.onmousemove = null;
			document.body.onmouseup = null;
			ul.onmouseover = null;
		}
	}

	let init = function()
	{
		let initPage = function()
		{
			let cartesButton = document.querySelectorAll(".readMore-container .openCarteButton");
			let cartesImg = document.querySelectorAll(".readMore-container > img");

			for (let i = cartesButton.length - 1; i >= 0; i--)
			{
				cartesButton[i].checked = false;
				cartesButton[i].addEventListener("change", function()
				{
					if (cartesButton[i].checked)
					{
						cartesButton[i].style.height = cartesImg[i].offsetHeight + "px" ;
					}
					else
					{
						cartesButton[i].style = "" ;
					}
				}, false);
			}		
		}

		let initUpdateCartes = function()
		{
			let carteImgList = document.querySelectorAll(".carteImg");
			for (let i = carteImgList.length - 1; i >= 0; i--)
			{
				carteImgList[i].addEventListener("change", updateCarteImg, false);
			}

			let carteTitle = document.querySelectorAll(".readMore-container .carteTitle");
			for (let i = carteTitle.length - 1; i >= 0; i--)
			{
				carteTitle[i].addEventListener("change", function()
				{
					updateCarteTitle(carteTitle[i], "title");
				}, false);
			}	
		}

		let initUpdatePlats = function()
		{
			let compo = document.querySelectorAll(".readMore-container .platCompo");
			for (let i = compo.length - 1; i >= 0; i--)
			{
				compo[i].addEventListener("change", function()
				{
					updatePlat(compo[i], "compo");
				}, false);
			}

			let plat = document.querySelectorAll(".readMore-container .plat");
			for (let i = plat.length - 1; i >= 0; i--)
			{
				plat[i].addEventListener("change", function()
				{
					updatePlat(plat[i], "name");
				}, false);
			}	

			let prix = document.querySelectorAll(".readMore-container .prix");
			for (let i = prix.length - 1; i >= 0; i--)
			{
				prix[i].addEventListener("change", function()
				{
					updatePlat(prix[i], "price");
				}, false);
			}		
		}

		let initChangeOrderButton = function()
		{
			let button = document.querySelectorAll(".moveOrderButton");
			for (let i = button.length - 1; i >= 0; i--)
			{
				button[i].addEventListener("mousedown", moveOrder, false);
			}
		}

		let initRecordButton = function()
		{
			let button = document.getElementById("recordChanges");
			button.addEventListener("click", recordChanges, false);
		}

		initPage();
		initUpdatePlats();
		initUpdateCartes();
		initChangeOrderButton();
		initRecordButton();
	}
	init();
});