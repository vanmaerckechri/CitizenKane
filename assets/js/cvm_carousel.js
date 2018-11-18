 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
	let loadCarousel = function(id, path, fileName, imgAlt)
	{
		let carouselContainer = document.getElementById(id);
		let carouselIndex = -1;

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

		//load image
		let carouselImg = carouselContainer.querySelector("img");
		let loadImage = function(imageIndex)
		{
			let imageLength = fileName.length - 1;
			let src;
			let alt;
			if (imageIndex < 0)
			{
				imageIndex = imageLength;
			}
			else if (imageIndex > imageLength)
			{
				imageIndex = 0;
			}
			carouselIndex = imageIndex;
			src = path + fileName[carouselIndex];
			alt = path + imgAlt[carouselIndex];
			carouselImg.src = src;
			carouselImg.alt = alt;

			updateSelectedNavBtn(imageIndex);
		}

		//initialize arrow nav
		let arrows = carouselContainer.querySelectorAll("button");
		for (let i = arrows.length - 1; i >= 0; i--)
		{
			let directionIndex = i === 1 ? 1 : -1;
			arrows[i].addEventListener("click", function()
			{
				let nextIndex = carouselIndex + directionIndex;
				loadImage(nextIndex);
			}, false);			
		}

		//create individual nav
		let carouselNav = carouselContainer.querySelector(".carousel-nav");
		for (let i = 0, length = fileName.length; i < length; i++)
		{
			let button = document.createElement("button");
			carouselNav.appendChild(button);
			button.addEventListener("click", loadImage.bind(this, i), false);
		}

		//load first image
		loadImage(0);

		// carousel auto
		let carouselManual = false;
		let carouselAuto = setInterval(function()
		{
			if (carouselManual === false)
			{
				let nextIndex = carouselIndex + 1;
				loadImage(nextIndex);
			}
		}, 5000);
		carouselContainer.addEventListener("mouseover", function()
		{
			carouselManual = true
		}, false);
		carouselContainer.addEventListener("mouseout", function()
		{
			carouselManual = false;
		}, false);
	}
	let path = "assets/img/";
	let fileName = ["restaurant_facade.jpg", "restaurant_interieur01.jpg", "restaurant_plat01.jpg", "terrasse.jpg" ,"restaurant_interieur02.jpg", "restaurant_plat02.jpg", "restaurant_deco.jpg"];
	let imgAlt = ["", "", "", "", "", "", ""];
	loadCarousel("carouselDemo01", path, fileName, imgAlt)
});