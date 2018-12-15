 "use strict";

let inputsValueAtStart = [];
let mainContentValues = [];
let updatePlats = {};
let updatePlatsOrder = {};
let newCarteImg = {};
let newCartePdf = {};
let updateCartePdfId = [];
let newImageInNewCarte = [];
let updateCarteImageCartesId = [];
let updateCartesTitle = {};
let updateFamilyCarteTitleList = {};
let deletePlatsList = {};
let deleteCartesList = {};

window.addEventListener("load", function(event)
{
	// -- Save to DB --

	let detectNewPlats = function(cartes= document)
	{
		let newPlats = cartes.querySelectorAll(".newPlat");
		let newPlatsContent = {};
		for (let i = 0, length = newPlats.length; i < length; i ++)
		{
			newPlats[i].classList.remove("newPlat");
			let title = newPlats[i].querySelector(".plat").value;
			let prix = newPlats[i].querySelector(".prix").value;
			let compo = newPlats[i].querySelector(".platCompo").value;

			// new plat in carte who already exist
			if (cartes === document)
			{
				let carteId = newPlats[i].parentNode.id;
				let index = carteId.indexOf("__");
				carteId = carteId.slice(index + 2, carteId.length);

				newPlatsContent[carteId] = !newPlatsContent[carteId] ? {} : newPlatsContent[carteId];
				newPlatsContent[carteId][title] = !newPlatsContent[title] ? {} : newPlatsContent[title];
				newPlatsContent[carteId][title]["price"] = prix;
				newPlatsContent[carteId][title]["compo"] = compo;
			}
			// new plat in new carte
			else
			{
				newPlatsContent[title] = !newPlatsContent[title] ? {} : newPlatsContent[title];
				newPlatsContent[title]["price"] = prix;
				newPlatsContent[title]["compo"] = compo;
			}
		}
		return newPlatsContent;	
	}

	let detectNewCartes = function(family = document)
	{
		let newCartes = family.querySelectorAll(".newCarte");
		let newCarteContent = {};
		newCarteContent[page] = {};

		for (let i = 0, length = newCartes.length; i < length; i++)
		{
			newCartes[i].classList.remove("newCarte");
			let newCarteTitle = newCartes[i].querySelector(".carteTitle").value;
			let styleCarte = newCartes[i].querySelector(".uploadPdf-container") ? "link" : "fold";
			// new carte in family who already exist
			let parent = Tools.focusParent("familyContainer", newCartes[i]);
			let famName = parent.querySelector(".familyTitle").value;
			newCarteContent[page][famName] = !newCarteContent[page][famName] ? {} : newCarteContent[page][famName];
			newCarteContent[page][famName][newCarteTitle] = detectNewPlats(newCartes[i]);
			newCarteContent[page][famName][newCarteTitle]["styleCarte"] = styleCarte;
		}

		return newCarteContent;	
	}

	let detectImportCarte = function()
	{
		let importList = document.querySelectorAll(".importCarte");
		let importCarte = {};
		for (let i = importList.length - 1; i >= 0; i--)
		{
			let id = Tools.cleanIdBeforeThisChar(importList[i].id, "__");
			let familyTitle = Tools.focusParent("familyContainer", importList[i]);
			familyTitle = familyTitle.querySelector(".familyTitle").value;

			importCarte[page] = typeof importCarte[page] == "undefined" ? {} : importCarte[page];
			importCarte[page][id] = familyTitle;
		}
		return importCarte;
	}

	let recordChanges = function()
	{
		let formAction = "index.php?action=" + page;
		let form = Tools.createElem(["form"], [["action", "method", "enctype"]], [[formAction, "post", "multipart/form-data"]]);

		let importCartes = detectImportCarte();
		if (Tools.checkObjectNotEmpty(importCartes) === true)
		{
			importCartes = JSON.stringify(importCartes);
			let importCartesInput = Tools.createElem(["input"], [["type", "value", "name"]], [["text", importCartes, "importCartes"]]);
			form.appendChild(importCartesInput);			
		}

		let newCartes = detectNewCartes();
		if (Tools.checkObjectNotEmpty(newCartes) === true)
		{
			newCartes = JSON.stringify(newCartes);
			let newCartesList = Tools.createElem(["input"], [["type", "value", "name"]], [["text", newCartes, "newCartes"]]);

			// new img
			let newImgList = document.querySelectorAll(".newImage");
			for (let i = 0, length = newImgList.length; i < length; i++)
			{
				newImgList[i].setAttribute("name", "onNewCarte" + i)
				form.appendChild(newImgList[i]);
			}

			// new pdf (for carte link style)
			let newPdfList = document.querySelectorAll(".uploadPdf");
			for (let i = 0, length = newPdfList.length; i < length; i++)
			{
				newPdfList[i].setAttribute("name", "pdfOnNewCarte" + i)
				form.appendChild(newPdfList[i]);
			}

			form.appendChild(newCartesList);
		}

		let newPlats = detectNewPlats();
		if (Tools.checkObjectNotEmpty(newPlats) === true)
		{
			newPlats = JSON.stringify(newPlats);
			let newPlatsList = Tools.createElem(["input"], [["type", "value", "name"]], [["text", newPlats, "newPlats"]]);
			form.appendChild(newPlatsList);
		}	

		if (Tools.checkObjectNotEmpty(updateFamilyCarteTitleList) === true)
		{
			updateFamilyCarteTitleList = JSON.stringify(updateFamilyCarteTitleList);
			let familyCarteTitleList = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updateFamilyCarteTitleList, "familyCarteTitle"]]);
			form.appendChild(familyCarteTitleList);
		}

		if (Tools.checkObjectNotEmpty(newCarteImg) === true)
		{
			let index = 0;
			for (let propertyTitle in newCarteImg)
			{
				let newImg = newCarteImg[propertyTitle];
				newImg.setAttribute("name", "onAlreadyExistCarte" + index)
				updateCarteImageCartesId.push(propertyTitle);
				form.appendChild(newImg);
				index += 1;
			}
			updateCarteImageCartesId = JSON.stringify(updateCarteImageCartesId);
			let cartesId = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updateCarteImageCartesId, "updateCarteImageCartesId"]]);
			form.appendChild(cartesId);
		}

		if (Tools.checkObjectNotEmpty(newCartePdf) === true)
		{
			let index = 0;
			for (let propertyTitle in newCartePdf)
			{
				let newPdf = newCartePdf[propertyTitle];
				newPdf.setAttribute("name", "pdfOnAlreadyExistCarte" + index)
				updateCartePdfId.push(propertyTitle);
				form.appendChild(newPdf);
				index += 1;
			}
			updateCartePdfId = JSON.stringify(updateCartePdfId);
			let cartesId = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updateCartePdfId, "updateCartePdfId"]]);
			form.appendChild(cartesId);
		}

		if (Tools.checkObjectNotEmpty(updateCartesTitle) === true)
		{
			updateCartesTitle = JSON.stringify(updateCartesTitle);
			let cartesTitle = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updateCartesTitle, "updateCartesTitle"]]);
			form.appendChild(cartesTitle);
		}

		if (Tools.checkObjectNotEmpty(updatePlats) === true)
		{
			updatePlats = JSON.stringify(updatePlats);
			let plats = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updatePlats, "updatePlats"]]);
			form.appendChild(plats);
		}

		if (Tools.checkObjectNotEmpty(updatePlatsOrder) === true)
		{
			updatePlatsOrder = JSON.stringify(updatePlatsOrder);
			let platsOrder = Tools.createElem(["input"], [["type", "value", "name"]], [["text", updatePlatsOrder, "updatePlatsOrder"]]);
			form.appendChild(platsOrder);
		}	

		if (Tools.checkObjectNotEmpty(deletePlatsList) === true)
		{
			deletePlatsList = JSON.stringify(deletePlatsList);
			let deletePlatsInput = Tools.createElem(["input"], [["type", "value", "name"]], [["text", deletePlatsList, "deletePlatsList"]]);
			form.appendChild(deletePlatsInput);
		}	

		if (Tools.checkObjectNotEmpty(deleteCartesList) === true)
		{
			deleteCartesList = JSON.stringify(deleteCartesList);
			let deleteCartesInput = Tools.createElem(["input"], [["type", "value", "name"]], [["text", deleteCartesList, "deleteCartesList"]]);
			form.appendChild(deleteCartesInput);
		}	

		if (Tools.checkObjectNotEmpty(importCartes) === true || Tools.checkObjectNotEmpty(newCartes) === true || Tools.checkObjectNotEmpty(newPlats) === true || Tools.checkObjectNotEmpty(updateFamilyCarteTitleList) === true || Tools.checkObjectNotEmpty(newCarteImg) === true || newImageInNewCarte.length > 0 || Tools.checkObjectNotEmpty(updateCartesTitle) === true || Tools.checkObjectNotEmpty(newCartePdf) === true || Tools.checkObjectNotEmpty(updatePlats) === true || Tools.checkObjectNotEmpty(updatePlatsOrder) === true || Tools.checkObjectNotEmpty(deletePlatsList) === true || Tools.checkObjectNotEmpty(deleteCartesList) === true)
		{
			document.body.appendChild(form);
			form.submit();
		}
	}

	// -- Manage Cartes --

	let detectBodyUpdate = function()
	{
		let currentInputsList = document.querySelectorAll("input");
		let haveChange = false;

		for (let i = 0, length = currentInputsList.length; i < length; i++)
		{
			if (inputsValueAtStart[i] != currentInputsList[i].value)
			{
				haveChange = true;
				break;
			}
		}

		let recordChangesButton = document.getElementById("recordChanges");
		if (haveChange === true && recordChangesButton.classList.contains("displayNone"))
		{
			recordChangesButton.classList.remove("displayNone");
		}
		else if (haveChange === false && !recordChangesButton.classList.contains("displayNone"))
		{
			recordChangesButton.classList.add("displayNone");
		}
	}

	let addPlat = function(event)
	{
		event = typeof event.target == "undefined" ? event : event.target;
		let li = Tools.createElem(["li"], [["class"]], [["newPlat"]]);
		let plat = Tools.createElem(["input"], [["class", "type", "placeholder", "autocomplete"]], [["plat", "text", "Titre du Plat", "off"]]);
		let prix = Tools.createElem(["input"], [["class", "type", "min", "step", "placeholder", "autocomplete"]], [["prix", "number", 0, 0.1, "Prix du Plat", "off"]]);
		let delButton = Tools.createElem(["button"], [["class"]], [["btn_platDelete"]]);
		delButton.innerHTML = "X";
		let compo = Tools.createElem(["input"], [["class", "type", "placeholder", "autocomplete"]], [["platCompo", "text", "Composition du Plat", "off"]]);
		li.appendChild(plat);
		li.appendChild(prix);
		li.appendChild(delButton);
		li.appendChild(compo);

		event.parentNode.parentNode.insertBefore(li, event.parentNode);

		delButton.addEventListener("click", function()
		{
			this.parentNode.remove();

			detectBodyUpdate();
		}, false);
	
		prix.addEventListener("change", function()
		{
			if (isNaN(parseInt(prix.value)))
			{
				prix.value = 0;

				detectBodyUpdate();
			}
		}, false);

		detectBodyUpdate();

		return li;
	}

	let switchNewCarteStyle = function(radio)
	{
		let parent = radio.parentNode;
		let radios = parent.querySelectorAll(".radio");
		let toggle = !radio.classList.contains("radio_selected") ? true : false;
		for (let i = radios.length - 1; i >= 0; i--)
		{
			if (toggle == true)
			{
				radios[i].classList.toggle("radio_selected");
			}
		}
	}

	let addCarte = function(event)
	{
		event = typeof event.target == "undefined" ? event : event.target;
		// detect carte style
		let familyContainer = Tools.focusParent("familyContainer", event);
		let radios = familyContainer.querySelectorAll(".radio");
		let style = radios[0].classList.contains("radio_selected") ? "folder" : "link";

		let divContainer = Tools.createElem(["div"], [["class"]], [["readMore-container newCarte"]]);
		let openCarteButton = Tools.createElem(["input"], [["type", "class", "aria-label"]], [["checkbox", "openCarteButton", "afficher la carte"]]);
		let imgCarte = Tools.createElem(["img"], [["src", "alt"]], [["./assets/img/test/carte_empty.png", "photo représentant la carte"]]);
		let inputUploadImg = Tools.createElem(["input"], [["type", "class", "accept"]], [["file", "carteImg newImage", "image/png, image/jpeg"]]);
		let deleteCarte = Tools.createElem(["button"], [["class"]], [["btn_carteDelete"]]);
		deleteCarte.innerHTML = "X"

		divContainer.appendChild(openCarteButton);
		divContainer.appendChild(imgCarte);
		divContainer.appendChild(inputUploadImg);
		divContainer.appendChild(deleteCarte);

		let divContent = Tools.createElem(["div"], [["class"]], [["readMore-content"]]);
		let carteTitle = Tools.createElem(["input"], [["type", "class", "value", "placeholder"]], [["text", "carteTitle h4", "titre de la carte", "Carte sans titre"]]);

		if (style == "folder")
		{
			var ul = document.createElement("ul");
			var li = document.createElement("li");
			var addPlatButton = Tools.createElem(["button"], [["class"]], [["addPlat btn btn_add"]]);
			addPlatButton.innerHTML = "ajouter un plat";

			li.appendChild(addPlatButton);
			ul.appendChild(li);
			divContent.appendChild(carteTitle);
			divContent.appendChild(ul);
		}
		else
		{
			let uploadPdfContainer = Tools.createElem(["div"], [["class"]], [["uploadPdf-container"]]);
			let labelUploadPdf = document.createElement("p");
			let inputUploadPdf = Tools.createElem(["input"], [["type", "class", "accept"]], [["file", "uploadPdf", "application/pdf"]]);
			labelUploadPdf.innerHTML = "PDF: ";

			divContent.classList.add("cartePdf-content");

			uploadPdfContainer.appendChild(labelUploadPdf);
			uploadPdfContainer.appendChild(inputUploadPdf);
			divContent.appendChild(uploadPdfContainer);
			divContent.appendChild(carteTitle);

			openCarteButton.remove();
		}
		divContainer.appendChild(divContent);

		let addNewCarteButtonContainer = Tools.focusParent("addCarte_btnContainer", event);
		familyContainer.insertBefore(divContainer, addNewCarteButtonContainer);

		// delete carte button
		deleteCarte.addEventListener("click", function()
		{
			let carte = this.parentNode;
			let fam = carte.parentNode;
			carte.remove();

			// delete family if family does'nt have carte
			let famCartes = fam.querySelectorAll(".readMore-container");
			if (famCartes.length === 0)
			{
				fam.remove();
			}

			detectBodyUpdate();
		}, false);

		// limit unfold button to the height of the image
		openCarteButton.checked = true;
		openCarteButton.style.height = imgCarte.offsetHeight + "px" ;
		openCarteButton.addEventListener("change", function()
		{
			if (openCarteButton.checked)
			{
				openCarteButton.style.height = imgCarte.offsetHeight + "px";
			}
			else
			{
				openCarteButton.style = "" ;
			}
		}, false);

		// button to add new plat
		if (style == "folder")
		{
			addPlatButton.addEventListener("click", addPlat, false);
		
			// avoid titles duplicates
			carteTitle.value = Tools.fixDupTitle("carteTitle", carteTitle);
			carteTitle.addEventListener("change", function()
			{
				carteTitle.value = Tools.fixDupTitle("carteTitle", carteTitle);

				detectBodyUpdate();
			}, false);
		}

		detectBodyUpdate();

		return divContainer;
	}

	let addFamilyCarte = function(event)
	{
		let divParent = Tools.createElem(["div"], [["class"]], [["familyContainer newFam"]]);
		let famiTitleInput = Tools.createElem(["input"], [["type", "class", "value"]], [["text", "familyTitle h3", "Nouvelle Famille de Cartes"]]);

		// create new addCarteButton
		let radioLink = Tools.createElem(["span", "span", "div"], [["class"], [], ["class"]], [["radioFolder"], [], ["radio radioFolder_container radio_selected"]]);
		let radioLinkText = document.createElement("p");
		radioLinkText.innerHTML = "carte dépliable";
		radioLink.appendChild(radioLinkText);

		let radioFolder = Tools.createElem(["span", "span", "div"], [["class"], [], ["class"]], [["radioLink"], [], ["radio radioLink_container"]]);
		let radioFolderText = document.createElement("p");
		radioFolderText.innerHTML = "carte vers un lien pdf";
		radioFolder.appendChild(radioFolderText);

		let addCarteButton = Tools.createElem(["button"], [["class"]], [["btn addCarte"]]);
		addCarteButton.innerHTML = "ajouter une carte";
		let addCarteButtonContainer = Tools.createElem(["div"], [["class"]], [["addCarte_btnContainer"]]);
		addCarteButtonContainer.appendChild(addCarteButton);
		addCarteButtonContainer.appendChild(radioLink);
		addCarteButtonContainer.appendChild(radioFolder);

		let importCarte_btnContainer = document.querySelector(".importCarte_btnContainer").cloneNode(true);
		let importButton = importCarte_btnContainer.querySelector("button");
		importButton.addEventListener("click", importCarte, false);


		divParent.appendChild(famiTitleInput);
		divParent.appendChild(addCarteButtonContainer);
		divParent.appendChild(importCarte_btnContainer);
		event.target.parentNode.insertBefore(divParent, event.target);

		// event addCarte and option between 2 carte style
		addCarteButton.addEventListener("click", addCarte, false);
		radioLink.addEventListener("click", switchNewCarteStyle.bind(this, radioLink), false);
		radioFolder.addEventListener("click", switchNewCarteStyle.bind(this, radioFolder), false);

		// create new carte in the new family at spawn
		//addCarte(addCarteButtonContainer);

		// avoid titles duplicates
		famiTitleInput.value = Tools.fixDupTitle("familyTitle", famiTitleInput);
		famiTitleInput.addEventListener("change", function()
		{
			famiTitleInput.value = Tools.fixDupTitle("familyTitle", famiTitleInput);

			detectBodyUpdate();
		}, false);

		detectBodyUpdate();
	}

	let updateFamilyCarteTitle = function(event)
	{
		/*let idsFam = event.target.id;
		let index = idsFam.indexOf("__");
		idsFam = idsFam.slice(index + 2, idsFam.length);*/
		let inputFamTitle = event.target;
		let idsFam = Tools.cleanIdBeforeThisChar(inputFamTitle.id, "__");
		let famTitle = event.target.value;

		idsFam = idsFam.split("_").map(Number);
		for (let i = idsFam.length - 1; i >= 0; i--)
		{
			updateFamilyCarteTitleList[idsFam[i]] = famTitle;
		}

		detectBodyUpdate();
	}

	let updateCarteImg = function(event)
	{
		let idCarte = event.target.id.slice(10, event.target.id.length);
		newCarteImg[idCarte] = (event.target);

		detectBodyUpdate(event.target.value);
	}

	let updateCartePdf = function(event)
	{
		let idCarte = event.target.id.slice(10, event.target.id.length);
		newCartePdf[idCarte] = (event.target);

		detectBodyUpdate();
	}

	let updateCarteTitle = function(item)
	{
		/*let id = item.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);*/
		let id = Tools.cleanIdBeforeThisChar(item.id, "__");

		let dubClassName = "carteTitle";
		let titleDomElem = item;
		updateCartesTitle[id] = Tools.fixDupTitle(dubClassName, titleDomElem);

		detectBodyUpdate();
	}

	let updatePlat = function(item, platPropery)
	{
		/*let idPlat = item.parentNode.id;
		let index = idPlat.indexOf("__");
		idPlat = idPlat.slice(index + 2, idPlat.length);*/
		let idPlat = Tools.cleanIdBeforeThisChar(item.parentNode.id, "__");

		updatePlats[idPlat] = !updatePlats[idPlat] ? {} : updatePlats[idPlat];
		if (platPropery == "price" && isNaN(parseInt(item.value)))
		{
			item.value = 0;
		}
		updatePlats[idPlat][platPropery] = item.value;

		detectBodyUpdate();
	}

	let importCarte = function(event)
	{
		let importButtonContainer = Tools.focusParent("importCarte_btnContainer", event.target)
		let currentCarteId = importButtonContainer.querySelector(".carteForOtherPage").value;
		currentCarteId = Tools.cleanIdBeforeThisChar(currentCarteId, "__");

		// get carte obj by id
		let importCarteObj; 
		let idCarte;
		for (let fam in cartesForOtherPages)
		{
			for (let carteId in cartesForOtherPages[fam])
			{
				if (carteId == currentCarteId)
				{
					idCarte = currentCarteId;
					importCarteObj = cartesForOtherPages[fam][carteId];
					break;
				}
			}
		}

		// autoSelect the good radio style for import
		let famContainer = Tools.focusParent("familyContainer", event.target);
		let radio;
		if (importCarteObj["description"]["style"] == "link")
		{
			radio = famContainer.querySelector(".radioLink_container")
			switchNewCarteStyle(radio);
		}
		else
		{
			radio = famContainer.querySelector(".radioFolder_container")
			switchNewCarteStyle(radio);			
		}

		// carte
		let importedCarte = addCarte(radio);
		importedCarte.classList.remove("newCarte");
		importedCarte.classList.add("importCarte");
		importedCarte.id = "importCarte__" + idCarte;
		let carteImg = importedCarte.querySelector("img");
		carteImg.src = "./assets/img/" + importCarteObj["description"]["imgSrc"];
		let carteTitle = importedCarte.querySelector(".carteTitle");
		carteTitle.id = "carteTitle__" + idCarte;
		carteTitle.value = importCarteObj["description"]["title"];
		carteTitle.addEventListener("change", function()
		{
			updateCarteTitle(carteTitle, "title");
		}, false);

		// plats or pdf			
		if (importCarteObj["description"]["style"] == "fold")
		{
			let addPlatButton = importedCarte.querySelector(".addPlat");
			for (let plat in importCarteObj["plats"])
			{
				let currentPlat = importCarteObj["plats"][plat];
				let li = addPlat(addPlatButton);
				li.id = "idPlats__" + plat;
				li.classList.remove("newPlat");

				let inputPlat = li.querySelector(".plat");
				let inputPrix = li.querySelector(".prix");
				let inputPlatCompo = li.querySelector(".platCompo");

				inputPlat.value = currentPlat["name"];
				inputPrix.value = currentPlat["price"];
				inputPlatCompo.value = currentPlat["compo"];

				inputPlatCompo.addEventListener("change", function()
				{
					updatePlat(inputPlatCompo, "compo");
				}, false);

				inputPrix.addEventListener("change", function()
				{
					updatePlat(inputPrix, "price");
				}, false);

				inputPlat.addEventListener("change", function()
				{
					updatePlat(inputPlat, "name");
				}, false);
			}
		}
		else
		{
			let pdfFile = importCarteObj["description"]["link"];
			let pdfLink = Tools.createElem(["a"], [["href", "target", "rel"]], [["./assets/pdf/" + pdfFile, "_blank", "noopener"]]);
			carteImg.parentNode.insertBefore(pdfLink, carteImg);
			pdfLink.appendChild(carteImg);
		}
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

			detectBodyUpdate();
		}
	}

	let deletePlats = function(event)
	{
		/*let id = event.target.parentNode.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);*/
		let id = Tools.cleanIdBeforeThisChar(event.target.parentNode.id, "__");

		deletePlatsList[id] = "";

		event.target.parentNode.remove();

		detectBodyUpdate();
	}

	let deleteCartes = function(event)
	{
		let id = event.target.id;
		let index = id.indexOf("__");
		id = id.slice(index + 2, id.length);

		let fam = event.target.parentNode.parentNode;

		deleteCartesList[id] = page;
		event.target.parentNode.remove();

		// delete family if family does'nt have carte
		let famCartes = fam.querySelectorAll(".readMore-container");
		if (famCartes.length === 0)
		{
			fam.remove();
		}

		detectBodyUpdate();
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

			let radioLink = document.querySelectorAll(".radioLink_container");
			for (let i = radioLink.length - 1; i >= 0; i--)
			{			
				radioLink[i].addEventListener("click", switchNewCarteStyle.bind(this, radioLink[i]), false);
			}

			let radioFolder = document.querySelectorAll(".radioFolder_container");
			for (let i = radioFolder.length - 1; i >= 0; i--)
			{			
				radioFolder[i].addEventListener("click", switchNewCarteStyle.bind(this, radioFolder[i]), false);
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
				carteImgList[i].value = "";
			}

			let uploadPdf = document.querySelectorAll(".uploadPdf");
			for (let i = uploadPdf.length - 1; i >= 0; i--)
			{
				uploadPdf[i].addEventListener("change", updateCartePdf, false);
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

		let initImport = function()
		{
			let importButton = document.querySelectorAll(".btn_import");
			for (let i = importButton.length - 1; i >= 0; i--)
			{
				importButton[i].addEventListener("click", importCarte, false);
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

			let mainContentInputs = document.querySelectorAll("input");
			for (let i = 0, length = mainContentInputs.length; i < length; i++)
			{
				mainContentValues.push(mainContentInputs[i].value);
			}

			let inputsList = document.querySelectorAll("input");

			for (let i = 0, length = inputsList.length; i < length; i++)
			{
				inputsValueAtStart.push(inputsList[i].value);
			}
		}

		initPage();
		initAddFamilyCartes();
		initAddCarte();
		initAddPlat();
		initUpdatePlats();
		initUpdateCartes();
		initUpdateFamilyCarteTitle();
		initImport();
		initChangeOrderButton();
		initDeletePlat();
		initDeleteCarte();
		initRecordButton();
	}
	init();
						
});