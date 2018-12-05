 "use strict";

let newFamilyCartes = [];
let updatePlats = {};
let updatePlatsOrder = {};
let updateCarteImageNewImages = {};
let updateCarteImageCartesId = [];
let updateCartesTitle = {};
let updateFamilyCarteTitleList = {};
let deletePlatsList = {};
let deleteCartesList = {};

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

		if (checkObjectEmpty(updateFamilyCarteTitleList) === true)
		{
			updateFamilyCarteTitleList = JSON.stringify(updateFamilyCarteTitleList);
			let familyCarteTitleList = createElem(["input"], [["type", "value", "name"]], [["text", updateFamilyCarteTitleList, "familyCarteTitle"]]);
			form.appendChild(familyCarteTitleList);
		}

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

		let newPlats = document.querySelectorAll(".newPlat");
		if (newPlats.length > 0)
		{
			let newPlatsList = [];
			for (let i = newPlats.length - 1; i >= 0; i--)
			{
				let idCarte = newPlats[i].parentNode.id;
				let index = idCarte.indexOf("__");

				idCarte = idCarte.slice(index + 2, idCarte.length);
				let name = newPlats[i].querySelector(".plat").value;
				let prix = newPlats[i].querySelector(".prix").value;
				if (isNaN(parseInt(prix)))
				{
					prix = 0;
				}
				let compo = newPlats[i].querySelector(".platCompo").value;
				let plat =
				{
					idCarte: idCarte,
					name: name,
					prix: prix,
					compo: compo
				}
				newPlatsList.push(plat)
			}

			newPlatsList = JSON.stringify(newPlatsList);
			let newPlatsListInput = createElem(["input"], [["type", "value", "name"]], [["text", newPlatsList, "newPlatsList"]]);
			form.appendChild(newPlatsListInput);
		}

		if (checkObjectEmpty(deletePlatsList) === true)
		{
			deletePlatsList = JSON.stringify(deletePlatsList);
			let deletePlatsInput = createElem(["input"], [["type", "value", "name"]], [["text", deletePlatsList, "deletePlatsList"]]);
			form.appendChild(deletePlatsInput);
		}	

		if (checkObjectEmpty(deleteCartesList) === true)
		{
			deleteCartesList = JSON.stringify(deleteCartesList);
			let deleteCartesInput = createElem(["input"], [["type", "value", "name"]], [["text", deleteCartesList, "deleteCartesList"]]);
			form.appendChild(deleteCartesInput);
		}	

		if (checkObjectEmpty(updateFamilyCarteTitleList) === true || checkObjectEmpty(updateCarteImageNewImages) === true || checkObjectEmpty(updateCartesTitle) === true || checkObjectEmpty(updatePlats) === true || checkObjectEmpty(updatePlatsOrder) === true || newPlats.length > 0 || checkObjectEmpty(deletePlatsList) === true || checkObjectEmpty(deleteCartesList) === true)
		{
			document.body.appendChild(form);
			form.submit();
		}
	}

	let updateNewFamTitle = function(addCarteButton, event)
	{
		let idFamTemp = event.target.id;
		let index = idFamTemp.indexOf("__");
		idFamTemp = idFamTemp.slice(index + 2, idFamTemp.length);

		newFamilyCartes[idFamTemp]["title"] = event.target.value;

		addCarteButton.innerHTML = "Ajouter une Carte à la Famille \"" + event.target.value + "\"";
	}

	let addFamilyCarte = function(event)
	{
		let divParent = document.createElement("div");
		newFamilyCartes.push({});
		let famiTitleInput = createElem(["input"], [["type", "class", "id", "placeholder"]], [["text", "familyTitle h3", "newFamId__" + (newFamilyCartes.length - 1), "Nouvelle Famille de Cartes"]]);
		let addCarteButton = createElem(["button"], [["id", "class"]], [["addCarteForNewFam__" + (newFamilyCartes.length - 1), "btn"]]);
		addCarteButton.innerHTML = "Ajouter une Carte à la Famille \"Nouvelle Famille de Cartes\"";
		divParent.appendChild(famiTitleInput);
		divParent.appendChild(addCarteButton);
		event.target.parentNode.insertBefore(divParent, event.target);

		famiTitleInput.addEventListener("change", updateNewFamTitle.bind(this, addCarteButton), false);
		//addCarteButton.addEventListener("change", addCarteOnNewFam.bind(this, addCarteButton), false);
	}

	let addPlat = function(event)
	{
		let li = createElem(["li"], [["class"]], [["newPlat"]]);
		let plat = createElem(["input"], [["class", "type", "placeholder", "autocomplete"]], [["plat", "text", "Titre du Plat", "off"]]);
		let prix = createElem(["input"], [["class","type", "min", "step", "placeholder", "autocomplete"]], [["prix", "number", 0, 0.1, "Prix du Plat", "off"]]);
		let delButton = createElem(["button"], [["class"]], [["btn_platDelete"]]);
		delButton.innerHTML = "X";
		let compo = createElem(["input"], [["class","type", "placeholder", "autocomplete"]], [["platCompo", "text", "Composition du Plat", "off"]]);
		li.appendChild(plat);
		li.appendChild(prix);
		li.appendChild(delButton);
		li.appendChild(compo);
		event.target.parentNode.parentNode.insertBefore(li, event.target.parentNode);

		delButton.addEventListener("click", function()
		{
			this.parentNode.remove();
		}, false);
	}

	let addCarte = function(event)
	{
		let divContainer = createElem(["div"], [["class"]], [["readMore-container newCarte"]]);
		let openCarteButton = createElem(["input"], [["type", "class", "aria-label"]], [["checkbox", "openCarteButton", "afficher la carte"]]);
		let imgCarte = createElem(["img"], [["src", "alt"]], [["./assets/img/test/carte_empty.png", "photo représentant la carte"]]);
		let inputUploadImg = createElem(["input"], [["type", "class", "accept"]], [["file", "carteImg", "image/png, image/jpeg"]]);
		let deleteCarte = createElem(["button"], [["class"]], [["btn_carteDelete"]]);
		deleteCarte.innerHTML = "X"

		divContainer.appendChild(openCarteButton);
		divContainer.appendChild(imgCarte);
		divContainer.appendChild(inputUploadImg);
		divContainer.appendChild(deleteCarte);

		let divContent = createElem(["div"], [["class"]], [["readMore-content"]]);
		let carteTitle = createElem(["input"], [["type", "class", "placeholder"]], [["text", "carteTitle h4", "titre de la carte"]]);
		let ul = document.createElement("ul");
		let li = document.createElement("li");
		let addPlatButton = createElem(["button"], [["class"]], [["addPlat btn btn_add"]]);
		addPlatButton.innerHTML = "ajouter un plat";


		li.appendChild(addPlatButton);
		ul.appendChild(li);
		divContent.appendChild(carteTitle);
		divContent.appendChild(ul);
		divContainer.appendChild(divContent);

		event.target.parentNode.insertBefore(divContainer, event.target);

		deleteCarte.addEventListener("click", function()
		{
			this.parentNode.remove();
		}, false);

		openCarteButton.checked = true;
		openCarteButton.addEventListener("change", function()
		{
			if (openCarteButton.checked)
			{
				openCarteButton.style.height = imgCarte.offsetHeight + "px" ;
			}
			else
			{
				openCarteButton.style = "" ;
			}
		}, false);

		addPlatButton.addEventListener("click", addPlat, false);
	}

	let updateFamilyCarteTitle = function(event)
	{
		let idsFam = event.target.id.slice(10, event.target.id.length);
		idsFam = idsFam.split("_").map(Number);
		for (let i = idsFam.length - 1; i >= 0; i--)
		{
			updateFamilyCarteTitleList[idsFam[i]] = event.target.value;
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
	}

	let updatePlat = function(item, platPropery)
	{
		let idPlat = item.parentNode.id;
		let index = idPlat.indexOf("__");
		idPlat = idPlat.slice(index + 2, idPlat.length);

		updatePlats[idPlat] = !updatePlats[idPlat] ? {} : updatePlats[idPlat];
		if (isNaN(parseInt(item.value)))
		{
			item.value = 0;
		}
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
				if (event.target.nodeName == "LI" && event.target.id.indexOf("plats__") != -1)
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

	let deletePlats = function(event)
	{
		let id = event.target.parentNode.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);

		deletePlatsList[id] = "";

		event.target.parentNode.remove();
	}

	let deleteCartes = function(event)
	{
		let id = event.target.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);

		deleteCartesList[id] = "";
		event.target.parentNode.remove();		
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

		let initAddFamilyCartes = function()
		{
			let addFamCarteButton = document.getElementById("addFamCarte");
			addFamCarteButton.addEventListener("click", addFamilyCarte, false);
		}

		let initAddCarte = function()
		{
			let addCarteButtons = document.querySelectorAll(".addCarte");
			for (let i = addCarteButtons.length - 1; i >= 0; i--)
			{			
				addCarteButtons[i].addEventListener("click", addCarte, false);
			}
		}

		let initAddPlat = function()
		{
			let addPlatButtons = document.querySelectorAll(".addPlat");
			for (let i = addPlatButtons.length - 1; i >= 0; i--)
			{
				addPlatButtons[i].addEventListener("click", addPlat, false);
			}			
		}

		let initUpdateFamilyCarteTitle = function()
		{
			let familyTitle = document.querySelectorAll(".familyTitle");
			for (let i = familyTitle.length - 1; i >= 0; i--)
			{
				familyTitle[i].addEventListener("change", updateFamilyCarteTitle, false);
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

		let initDeletePlat = function()
		{
			let platDeleteButtons = document.querySelectorAll(".btn_platDelete");
			for (let i = platDeleteButtons.length - 1; i >= 0; i--)
			{
				platDeleteButtons[i].addEventListener("click", deletePlats, false);
			}			
		}

		let initDeleteCarte = function()
		{
			let deleteCartesButton = document.querySelectorAll(".btn_carteDelete");
			for (let i = deleteCartesButton.length - 1; i >= 0; i--)
			{
				deleteCartesButton[i].addEventListener("click", deleteCartes, false);
			}	
		}

		let initRecordButton = function()
		{
			let button = document.getElementById("recordChanges");
			button.addEventListener("click", recordChanges, false);
		}

		initPage();
		initAddFamilyCartes();
		initAddCarte();
		initAddPlat();
		initUpdatePlats();
		initUpdateCartes();
		initUpdateFamilyCarteTitle();
		initChangeOrderButton();
		initDeletePlat();
		initDeleteCarte();
		initRecordButton();
	}
	init();
});