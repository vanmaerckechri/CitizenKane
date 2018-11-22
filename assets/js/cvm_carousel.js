 "use strict";

window.addEventListener("load", function(event)
{
	let loadCarousel = function(id, imageList, imageLength)
	{
		let carouselContainer = document.getElementById(id);
		let carouselIndex = 0;

		//clean navigation buttons
		let updateSelectedNavBtn = function(index)
		{
			let navButtons = carouselContainer.querySelectorAll(".carousel-nav button");
			for (let i = navButtons.length - 1; i >= 0; i--)
			{
				if (navButtons[i].classList.contains("selected"))
				{
					navButtons[i].classList.remove("selected");
				}
			}
			navButtons[index].classList.add("selected");
		}

		let changeImage = function(imageIndex)
		{
			let imgLenght = carouselContainer.querySelectorAll("img").length;
			console.log(imgLenght)
			if (imgLenght <= 1)
			{
				let lastImage = carouselContainer.querySelector("img");
				let imageLengthIndex = fileName.length - 1;

				let removeOldImg = function()
				{
					let deleteTiming = setTimeout(function()
					{
						lastImage.remove();
					}, 500);
				}

				let update = function()
				{
					carouselIndex = imageIndex;
					carouselContainer.insertBefore(imageList[carouselIndex], lastImage);
					updateSelectedNavBtn(imageIndex);
				}

				if (imageIndex < 0)
				{
					imageIndex = imageLengthIndex;
				}
				else if (imageIndex > imageLengthIndex)
				{
					imageIndex = 0;
				}

				if (imageIndex > carouselIndex)
				{
					imageList[imageIndex].className = "";
					imageList[imageIndex].classList.add("moveNewImgToRight");
					lastImage.classList.add("moveOldImgToRight");
					removeOldImg();
					update();
				}
				else if(imageIndex < carouselIndex)
				{
					imageList[imageIndex].className = "";
					imageList[imageIndex].classList.add("moveNewImgToLeft");
					lastImage.classList.add("moveOldImgToLeft");
					removeOldImg();
					update();
				}
			}
		}

		//initialize arrow nav
		let arrows = carouselContainer.querySelectorAll("button");
		for (let i = arrows.length - 1; i >= 0; i--)
		{
			arrows[i].classList.remove("displayNone");
			let directionIndex = i === 1 ? 1 : -1;
			arrows[i].addEventListener("click", function()
			{
				let nextIndex = carouselIndex + directionIndex;
				changeImage(nextIndex);
			}, false);			
		}

		//create individual nav
		let carouselNav = carouselContainer.querySelector(".carousel-nav");
		for (let i = 0, length = fileName.length; i < length; i++)
		{
			let button = document.createElement("button");
			button.setAttribute("aria-label", "image" + i);
			carouselNav.appendChild(button);
			button.addEventListener("click", changeImage.bind(this, i), false);
			if (i == 0)
			{
				button.classList.add("selected");
			}
		}

		//load first image
		let img = carouselContainer.querySelector("img");
		if (img.getAttribute('src') === "")
		{
			img.setAttribute("src", imageList[0].src);
			changeImage(0);
		}

		// carousel auto
		let carouselManual = false;
		let carouselAuto;
		let launchAutoCarousel = function()
		{
			carouselAuto = setInterval(function()
			{
				let nextIndex = carouselIndex + 1;
				changeImage(nextIndex);
			}, 5000);
		}
		carouselContainer.addEventListener("mouseover", function()
		{
			clearInterval(carouselAuto);
		}, false);
		carouselContainer.addEventListener("mouseout", function()
		{
			launchAutoCarousel();
		}, false);
		launchAutoCarousel()
	}
	//load image
	let imageList = []
	let loadImages = function(id, path, fileName, imgAlt)
	{
		let imgLength = fileName.length;
		let imgLoadedLength = 0;

		let checkAllImgLoaded = function(event)
		{
			event.target.onload = null;
			imgLoadedLength += 1;
			if (imgLoadedLength === imgLength)
			{
				loadCarousel(id, imageList, imgLength);
			}
		}

		let carouselContainer = document.getElementById("carouselDemo01");

		for (let i = 0; i < imgLength; i++)
		{
			let img = new Image();
			img.onload = checkAllImgLoaded;
			img.src = path + fileName[i];
			img.alt = imgAlt[i];
			imageList.push(img);
		}
	}
	loadImages("carouselDemo01", path, fileName, imgAlt)
});