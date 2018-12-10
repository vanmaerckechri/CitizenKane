 "use strict";

window.addEventListener("load", function(event)
{
	let replaceImgLowByHigh = function()
	{
		let imgList = document.querySelectorAll("img");
		let countDown = imgList.length;
		for (let i = 0, length = countDown; i < length; i++)
		{
			let lowImg = imgList[i];
			let lowSrc = imgList[i].src;
			if (lowSrc.indexOf("_small") != -1)
			{
				let imgHd = new Image();
				imgHd.onload = function()
				{
					lowImg.src = this.src;
					countDown -= 1;
					if (countDown == 0)
					{
						mainContent = document.getElementById("carteResto").innerHTML
					}
				}
				imgHd.src = lowSrc.replace("_small", "");
			}
		}
	}
	replaceImgLowByHigh()
});