 "use strict";

window.addEventListener("load", function(event)
{
	class Tools
	{
		static focusParent(parentByClassName, child)
		{	
			let parent = child;
			while (!parent.classList.contains(parentByClassName))
			{
				parent = parent.parentNode;
			}
			return parent;
		}

		static cleanIdBeforeThisChar(dirtId, cleanBeforeMe)
		{
			let id = dirtId;
			let index = id.indexOf(cleanBeforeMe);
			return id.slice(index + cleanBeforeMe.length, id.length);
		}

		static checkObjectEmpty(object)
		{
			let result = false;
			for (let property in object)
			{
				result = true;
			}
			return result;
		}
	}

	class BeerProject 
	{
		constructor(beerProjectContainer) 
		{
			// clone main container to check admin updates later
			this.beerProjectContainer = beerProjectContainer;
			this.beerProjectContainerClone = beerProjectContainer.cloneNode(true);
			this.inputUpdateIdList = {};

			this.initInputs();
			this.initDeleteBrasserieButtons();
		}

		initInputs()
		{
			let that = this;
			let inputs = this.beerProjectContainer.querySelectorAll("input");
			for (let i = inputs.length - 1; i >= 0; i--)
			{
				inputs[i].addEventListener("change", this.checkUpdates.bind(this, that), false);
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
	}	

	let beerProjectContainer = document.querySelector(".beerproject-editions");
	let beerProject = new BeerProject(beerProjectContainer);
});