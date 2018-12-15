 "use strict";

window.addEventListener("load", function(event)
{
	class BeerProject 
	{
		constructor(beerProjectContainer) 
		{
			// clone main container to check admin updates later
			this.beerProjectContainer = beerProjectContainer;
			this.beerProjectContainerClone = beerProjectContainer.cloneNode(true);
			this.inputUpdateIdList = {};

			this.initInputs();
			this.initImgInputs();
			this.initDeleteBrasserieButtons();
			this.initAddNewBrasserieButton();
			this.initRecordButton();
		}

		initInputs()
		{
			let that = this;
			let inputs = this.beerProjectContainer.querySelectorAll(".brasseriesFromDb input");
			for (let i = inputs.length - 1; i >= 0; i--)
			{
				inputs[i].addEventListener("change", this.checkUpdates.bind(this, that), false);
			}
		}

		initImgInputs()
		{
			// reset value
			let inputs = this.beerProjectContainer.querySelectorAll(".brasserieImgInput");
			for (let i = inputs.length - 1; i >= 0; i--)
			{
				inputs[i].value = "";
			}
		}

		initDeleteBrasserieButtons()
		{
			let that = this;
			let deleteButtons = this.beerProjectContainer.querySelectorAll(".btn_carteDelete");
			for (let i = deleteButtons.length - 1; i >= 0; i--)
			{
				deleteButtons[i].addEventListener("click", this.deleteBrasserie.bind(this, that), false);
			}			
		}

		initAddNewBrasserieButton()
		{
			let that = this;
			let addNewBrasserieButton = this.beerProjectContainer.querySelector(".btn_addNewBrasserie");
			addNewBrasserieButton.addEventListener("click", this.addNewBrasserie.bind(this, that), false);
		}

		initRecordButton()
		{
			let that = this;
			let recordButton = document.getElementById("recordChanges");
			recordButton.addEventListener("click", this.record.bind(this, that), false);
		}

		toogleDisplayRecordButton()
		{
			let button = document.getElementById("recordChanges");
			// display record button
			if (this.beerProjectContainer.innerHTML != this.beerProjectContainerClone.innerHTML && button.classList.contains("displayNone"))
			{
				button.classList.remove("displayNone");
			}
			// hide record button
			if (this.beerProjectContainer.innerHTML == this.beerProjectContainerClone.innerHTML && !button.classList.contains("displayNone"))
			{
				button.classList.add("displayNone");
			}
		}

		deleteBrasserie(that, event)
		{
			let button = event.target;
			let brasserie = Tools.focusParent("beerproject-brasserie", button);
			let brasserieIdClean = Tools.cleanIdBeforeThisChar(brasserie.id, "__");

			brasserie.remove();
			that.inputUpdateIdList[brasserieIdClean] = "delete";

			that.toogleDisplayRecordButton();
		}

		checkUpdates(that, event)
		{
			let input = event.target;
			let brasserie = Tools.focusParent("beerproject-brasserie", input);
			let brasserieId = brasserie.id;
			let brasserieIdClean = Tools.cleanIdBeforeThisChar(brasserieId, "__");

			// update value in html code
			input.setAttribute('value', input.value);
			// check if current brasserie is different than cloned at start
			if (brasserie.innerHTML != that.beerProjectContainerClone.querySelector("#" + brasserieId).innerHTML)
			{
				that.inputUpdateIdList[brasserieIdClean] = "update";
			}
			else
			{
				if (that.inputUpdateIdList[brasserieIdClean])
				{
					delete that.inputUpdateIdList[brasserieIdClean];
				}
			}

			that.toogleDisplayRecordButton();
		}

		addNewBrasserie(that, event)
		{
			let addNewBrasserieButton = event.target;
			let newBrasserie = Tools.focusParent("beerproject-brasserie", addNewBrasserieButton);
			let newBrasserieClone = newBrasserie.cloneNode(true);
			let newBrasserieDate = newBrasserieClone.querySelector(".brasserieDate").value;

			// search place to put new brasserie by date
			let allBrasseries = that.beerProjectContainer.querySelectorAll(".beerproject-brasserie");
			for (let i = 1, length = allBrasseries.length; i < length; i++)
			{
				let brasserieDate = allBrasseries[i].querySelector(".brasserieDate").value;
				if (newBrasserieDate > brasserieDate)
				{
					// update class to prepare record to db
					newBrasserieClone.className = ("beerproject-brasserie newBrasserieToDb")
					// delete addNewBrasserieButton from clone before insert it
					newBrasserieClone.querySelector(".btn_addNewBrasserie").remove();
					// add deleteBrasserieButton to clone before insert it
					let deleteBrasserieButton = that.beerProjectContainer.querySelector(".btn_carteDelete").cloneNode(true);
					newBrasserieClone.insertBefore(deleteBrasserieButton, newBrasserieClone.querySelector("img"));
					deleteBrasserieButton.addEventListener("click", function()
					{
						newBrasserieClone.remove();
						that.toogleDisplayRecordButton();
					})
					// insert it
					allBrasseries[i].parentNode.insertBefore(newBrasserieClone, allBrasseries[i]);
					// reset board inputs for next new brasserie
					newBrasserie.querySelector(".brasserieImgInput").value = "";
					newBrasserie.querySelector(".brasserieTitle").value = "";
					newBrasserie.querySelector(".brasserieDate").value = "";
					newBrasserie.querySelector(".brasserieBeers").value = "";
					newBrasserie.querySelector(".brasserieUrl").value = "";
					break;
				}
			}
			that.toogleDisplayRecordButton();
		}

		getBrasserieInfos(brasserie)
		{
			let brasserieInfos = {};
			brasserieInfos["title"] = brasserie.querySelector(".brasserieTitle").value;
			brasserieInfos["date"] = brasserie.querySelector(".brasserieDate").value != "" ? brasserie.querySelector(".brasserieDate").value : false;
			brasserieInfos["beers"] = brasserie.querySelector(".brasserieBeers").value;
			brasserieInfos["link"] = brasserie.querySelector(".brasserieUrl") ? brasserie.querySelector(".brasserieUrl").value : "";
			return brasserieInfos;
		}

		record(that, event)
		{
			let formAction = "index.php?action=" + page;
			let form = createElem(["form"], [["action", "method", "enctype", "style"]], [[formAction, "post", "multipart/form-data", "display: none"]]);

			// update brasserie who already exit in db
			if (Tools.checkObjectNotEmpty(that.inputUpdateIdList) === true)
			{
				let inputUpdateList = {};
				for (let i in that.inputUpdateIdList)
				{
					if (that.inputUpdateIdList[i] == "update")
					{
						let brasserieId = "beerProjectId__" + i;
						let brasserie = beerProjectContainer.querySelector("#" + brasserieId);
						inputUpdateList[i] = that.getBrasserieInfos(brasserie);
						delete that.inputUpdateIdList[i];
					}
				}
				inputUpdateList = JSON.stringify(inputUpdateList);
				let inputUpdate = createElem(["input"], [["type", "value", "name"]], [["text", inputUpdateList, "inputUpdate"]]);
				form.appendChild(inputUpdate);
			}

			// delete brasserie to db
			if (Tools.checkObjectNotEmpty(that.inputUpdateIdList) === true)
			{
				let brasserieDeleteIdList = [];
				for (let i in that.inputUpdateIdList)
				{
					if (that.inputUpdateIdList[i] == "delete")
					{
						brasserieDeleteIdList.push(i);
						delete that.inputUpdateIdList[i];
					}
				}
				brasserieDeleteIdList = JSON.stringify(brasserieDeleteIdList);
				let brasserieToDelete = createElem(["input"], [["type", "value", "name"]], [["text", brasserieDeleteIdList, "brasserieToDelete"]]);
				form.appendChild(brasserieToDelete);
			}

			// insert new brasserie to db
			let newBrasserieList = that.beerProjectContainer.querySelectorAll(".newBrasserieToDb");
			let newBrasserieListToInsert = [];
			let length = newBrasserieList.length;
			if (length > 0)
			{
				for (let i = 0; i < length; i++)
				{
					newBrasserieListToInsert.push(that.getBrasserieInfos(newBrasserieList[i]));
				}
				newBrasserieListToInsert = JSON.stringify(newBrasserieListToInsert);
				let insertNewBrasserie = createElem(["input"], [["type", "value", "name"]], [["text", newBrasserieListToInsert, "insertNewBrasserie"]]);
				form.appendChild(insertNewBrasserie);		
			}

			// set img on brasseries who already in db
			let brasserieImgInput = that.beerProjectContainer.querySelectorAll(".brasseriesFromDb .brasserieImgInput");
			let brasserieImgId = [];

			if (brasserieImgInput.length > 0)
			{
				for (let i = 0, length = brasserieImgInput.length; i < length; i++)
				{
					if (brasserieImgInput[i].value != "")
					{
						let brasserieContainer = Tools.focusParent("brasseriesFromDb", brasserieImgInput[i]);
						let brasserieId = Tools.cleanIdBeforeThisChar(brasserieContainer.id, "__");
						brasserieImgInput[i].setAttribute("name", "onAlreadyExistBrasserie" + brasserieId);
						brasserieImgId.push(brasserieId); 
						form.appendChild(brasserieImgInput[i]);		
					}
				}
				brasserieImgId = JSON.stringify(brasserieImgId);
				let brasserieImgInputId = createElem(["input"], [["type", "value", "name"]], [["text", brasserieImgId, "brasserieImgInputId"]]);
				form.appendChild(brasserieImgInputId);		
			}

			// set img on new brasseries
			let newBrasserieImgInput = that.beerProjectContainer.querySelectorAll(".newBrasserieToDb .brasserieImgInput");

			if (newBrasserieImgInput.length > 0)
			{
				for (let i = 0, length = newBrasserieImgInput.length; i < length; i++)
				{
					if (newBrasserieImgInput[i].value != "")
					{
						newBrasserieImgInput[i].setAttribute("name", "onNewBrasserie" + i);
						form.appendChild(newBrasserieImgInput[i]);		
					}
				}
			}			

			document.body.appendChild(form);
			form.submit();
		}
	}	

	let beerProjectContainer = document.querySelector(".beerproject-editions");
	let beerProject = new BeerProject(beerProjectContainer);
});