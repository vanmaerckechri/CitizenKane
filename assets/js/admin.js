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

	// -- Tools --

	let incrStr = function(str)
	{
		let splitIndex = 0;
		let word;
		let num;
		let isNum = new RegExp(/^\d+$/);
		
		for (let i = str.length - 1; i >= 0; i--)
		{
			if (isNum.test(str[i]) === false)
			{
				splitIndex = i;
				break;
			}
		}

		word = str.slice(0, splitIndex + 1);
		num = str.slice(splitIndex + 1, str.length);
		num = num == "" ? 0 : parseInt(num, 10) + 1;

		return word + num;
	}

	let checkDup = function(array, string)
	{
		for (let i = array.length - 1; i >= 0; i--)
		{
			if (array[i].toUpperCase() === string.toUpperCase())
			{
				return true;
			}
		}
		return false;
	}

	let fixDupTitle = function(className, item)
	{
		let title = item.value;
		// if title already exist incr it
		let carteTitleList = [];
		let cartesTitle = document.querySelectorAll("." + className);
		for (let i = cartesTitle.length - 1; i >= 0; i--)
		{
			if (cartesTitle[i] != item)
			{
				carteTitleList.push(cartesTitle[i].value)
			}
		}

		while (checkDup(carteTitleList , title))
		{
			title = incrStr(title);
		}
		item.value = title;
		return title;
	}

	let checkObjectEmpty = function(object)
	{
		let result = false;
		for (let property in object)
		{
			result = true;
		}
		return result;
	}

	let focusParent = function(parentClassName, child)
	{	
		let parent = child;
		while (!parent.classList.contains(parentClassName))
		{
			parent = parent.parentNode;
		}
		return parent;
	}

	let cleanIdBeforeThisChar = function(dirtId, cleanBeforeMe)
	{
		let id = dirtId;
		let index = id.indexOf(cleanBeforeMe);
		return id.slice(index + cleanBeforeMe.length, id.length);
	}

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
			let newCarteTitle = newCartes[i].querySelector(".carteTitle") ? newCartes[i].querySelector(".carteTitle").value : "link" + i;
			// new carte in family who already exist
			let parent = focusParent("familyContainer", newCartes[i]);
			let famName = parent.querySelector(".familyTitle").value;
			newCarteContent[page][famName] = !newCarteContent[page][famName] ? {} : newCarteContent[page][famName];
			newCarteContent[page][famName][newCarteTitle] = detectNewPlats(newCartes[i]);
		}

		return newCarteContent;	
	}

	let recordChanges = function()
	{
		let formAction = "index.php?action=" + page;
		let form = createElem(["form"], [["action", "method", "enctype"]], [[formAction, "post", "multipart/form-data"]]);

		let newCartes = detectNewCartes();
		let newPlats = detectNewPlats();

		if (checkObjectEmpty(newCartes) === true)
		{
			newCartes = JSON.stringify(newCartes);
			let newCartesList = createElem(["input"], [["type", "value", "name"]], [["text", newCartes, "newCartes"]]);

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

		if (checkObjectEmpty(newPlats) === true)
		{
			newPlats = JSON.stringify(newPlats);
			let newPlatsList = createElem(["input"], [["type", "value", "name"]], [["text", newPlats, "newPlats"]]);
			form.appendChild(newPlatsList);
		}	

		if (checkObjectEmpty(updateFamilyCarteTitleList) === true)
		{
			updateFamilyCarteTitleList = JSON.stringify(updateFamilyCarteTitleList);
			let familyCarteTitleList = createElem(["input"], [["type", "value", "name"]], [["text", updateFamilyCarteTitleList, "familyCarteTitle"]]);
			form.appendChild(familyCarteTitleList);
		}

		if (checkObjectEmpty(newCarteImg) === true)
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
			let cartesId = createElem(["input"], [["type", "value", "name"]], [["text", updateCarteImageCartesId, "updateCarteImageCartesId"]]);
			form.appendChild(cartesId);
		}

		if (checkObjectEmpty(newCartePdf) === true)
		{
			let index = 0;
			for (let propertyTitle in newCartePdf)
			{
				let newPdf = newCartePdf[propertyTitle];
				newPdf.setAttribute("name", "pdfOnAlreadyExistCarte" + index)
				updateCartePdfId.push(propertyTitle);
				form.appendChild(newPdf);
				index += 1;

				console.log(newPdf)
			}
			updateCartePdfId = JSON.stringify(updateCartePdfId);
			let cartesId = createElem(["input"], [["type", "value", "name"]], [["text", updateCartePdfId, "updateCartePdfId"]]);
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

		if (checkObjectEmpty(newCartes) === true || checkObjectEmpty(newPlats) === true || checkObjectEmpty(updateFamilyCarteTitleList) === true || checkObjectEmpty(newCarteImg) === true || newImageInNewCarte.length > 0 || checkObjectEmpty(updateCartesTitle) === true || checkObjectEmpty(newCartePdf) === true || checkObjectEmpty(updatePlats) === true || checkObjectEmpty(updatePlatsOrder) === true || checkObjectEmpty(deletePlatsList) === true || checkObjectEmpty(deleteCartesList) === true)
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
		let li = createElem(["li"], [["class"]], [["newPlat"]]);
		let plat = createElem(["input"], [["class", "type", "placeholder", "autocomplete"]], [["plat", "text", "Titre du Plat", "off"]]);
		let prix = createElem(["input"], [["class", "value", "type", "min", "step", "placeholder", "autocomplete"]], [["prix", "0", "number", 0, 0.1, "Prix du Plat", "off"]]);
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

	let addCarte = function(event, firstCarteForNewFam = false)
	{
		// detect carte style
		if (firstCarteForNewFam === false)
		{
			var radios = event.target.parentNode.querySelectorAll(".radio");
		}
		else
		{
			var radios = event.parentNode.querySelectorAll(".radio");
		}
		let style = radios[0].classList.contains("radio_selected") ? "folder" : "link";

		let divContainer = createElem(["div"], [["class"]], [["readMore-container newCarte"]]);
		let openCarteButton = createElem(["input"], [["type", "class", "aria-label"]], [["checkbox", "openCarteButton", "afficher la carte"]]);
		let imgCarte = createElem(["img"], [["src", "alt"]], [["./assets/img/test/carte_empty.png", "photo représentant la carte"]]);
		let inputUploadImg = createElem(["input"], [["type", "class", "accept"]], [["file", "carteImg newImage", "image/png, image/jpeg"]]);
		let deleteCarte = createElem(["button"], [["class"]], [["btn_carteDelete"]]);
		deleteCarte.innerHTML = "X"

		divContainer.appendChild(openCarteButton);
		divContainer.appendChild(imgCarte);
		divContainer.appendChild(inputUploadImg);
		divContainer.appendChild(deleteCarte);

		let divContent = createElem(["div"], [["class"]], [["readMore-content"]]);
		if (style == "folder")
		{
			var carteTitle = createElem(["input"], [["type", "class", "value"]], [["text", "carteTitle h4", "titre de la carte"]]);
			var ul = document.createElement("ul");
			var li = document.createElement("li");
			var addPlatButton = createElem(["button"], [["class"]], [["addPlat btn btn_add"]]);
			addPlatButton.innerHTML = "ajouter un plat";

			li.appendChild(addPlatButton);
			ul.appendChild(li);
			divContent.appendChild(carteTitle);
			divContent.appendChild(ul);
		}
		else
		{
			let uploadPdfContainer = createElem(["div"], [["class"]], [["uploadPdf-container"]]);
			let labelUploadPdf = document.createElement("p");
			let inputUploadPdf = createElem(["input"], [["type", "class", "accept"]], [["file", "uploadPdf", "application/pdf"]]);
			labelUploadPdf.innerHTML = "PDF: ";

			divContent.classList.add("cartePdf-content");

			uploadPdfContainer.appendChild(labelUploadPdf);
			uploadPdfContainer.appendChild(inputUploadPdf);
			divContent.appendChild(uploadPdfContainer);

			openCarteButton.remove();
		}
		divContainer.appendChild(divContent);

		if (firstCarteForNewFam === false)
		{
			let familyContainer = focusParent("familyContainer", event.target);
			let addNewCarteButtonContainer = focusParent("addCarte_btnContainer", event.target);
			familyContainer.insertBefore(divContainer, addNewCarteButtonContainer);
		}
		else
		{
			let familyContainer = focusParent("familyContainer", firstCarteForNewFam);
			let addNewCarteButtonContainer = focusParent("addCarte_btnContainer", firstCarteForNewFam.parentNode);
			familyContainer.insertBefore(divContainer, addNewCarteButtonContainer);
		}

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
			carteTitle.value = fixDupTitle("carteTitle", carteTitle);
			carteTitle.addEventListener("change", function()
			{
				carteTitle.value = fixDupTitle("carteTitle", carteTitle);

				detectBodyUpdate();
			}, false);
		}

		detectBodyUpdate();
	}

	let addFamilyCarte = function(event)
	{
		let divParent = createElem(["div"], [["class"]], [["familyContainer newFam"]]);
		let famiTitleInput = createElem(["input"], [["type", "class", "value"]], [["text", "familyTitle h3", "Nouvelle Famille de Cartes"]]);

		// create new addCarteButton
		let radioLink = createElem(["span", "span", "div"], [["class"], [], ["class"]], [["radioLink"], [], ["radio radioLink_container radio_selected"]]);
		let radioLinkText = document.createElement("p");
		radioLinkText.innerHTML = "carte dépliable";
		radioLink.appendChild(radioLinkText);

		let radioFolder = createElem(["span", "span", "div"], [["class"], [], ["class"]], [["radioFolder"], [], ["radio radioFolder_container"]]);
		let radioFolderText = document.createElement("p");
		radioFolderText.innerHTML = "carte vers un lien pdf";
		radioFolder.appendChild(radioFolderText);

		let addCarteButton = createElem(["button"], [["class"]], [["btn addCarte"]]);
		addCarteButton.innerHTML = "ajouter une carte";
		let addCarteButtonContainer = createElem(["div"], [["class"]], [["addCarte_btnContainer"]]);
		addCarteButtonContainer.appendChild(addCarteButton);
		addCarteButtonContainer.appendChild(radioLink);
		addCarteButtonContainer.appendChild(radioFolder);

		divParent.appendChild(famiTitleInput);
		divParent.appendChild(addCarteButtonContainer);
		event.target.parentNode.insertBefore(divParent, event.target);

		// event addCarte and option between 2 carte style
		addCarteButton.addEventListener("click", addCarte, false);
		radioLink.addEventListener("click", switchNewCarteStyle.bind(this, radioLink), false);
		radioFolder.addEventListener("click", switchNewCarteStyle.bind(this, radioFolder), false);

		// create new carte in the new family at spawn
		addCarte(this, addCarteButton);

		detectBodyUpdate();
	}

	let updateFamilyCarteTitle = function(event)
	{
		/*let idsFam = event.target.id;
		let index = idsFam.indexOf("__");
		idsFam = idsFam.slice(index + 2, idsFam.length);*/
		let inputFamTitle = event.target;
		let idsFam = cleanIdBeforeThisChar(inputFamTitle.id, "__");
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
		let id = cleanIdBeforeThisChar(item.id, "__");

		let dubClassName = "carteTitle";
		let titleDomElem = item;
		updateCartesTitle[id] = fixDupTitle(dubClassName, titleDomElem);

		detectBodyUpdate();
	}

	let updatePlat = function(item, platPropery)
	{
		/*let idPlat = item.parentNode.id;
		let index = idPlat.indexOf("__");
		idPlat = idPlat.slice(index + 2, idPlat.length);*/
		let idPlat = cleanIdBeforeThisChar(item.parentNode.id, "__");

		updatePlats[idPlat] = !updatePlats[idPlat] ? {} : updatePlats[idPlat];
		if (platPropery == "price" && isNaN(parseInt(item.value)))
		{
			item.value = 0;
		}
		updatePlats[idPlat][platPropery] = item.value;

		detectBodyUpdate();
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
		let id = cleanIdBeforeThisChar(event.target.parentNode.id, "__");

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

		deleteCartesList[id] = "";
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
		initChangeOrderButton();
		initDeletePlat();
		initDeleteCarte();
		initRecordButton();
	}
	init();
						
});