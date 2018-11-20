 "use strict";

window.addEventListener("load", function(event)
{
	let replaceImgLowByHigh = function()
	{
		let imgList = document.querySelectorAll("img");
		let onlyLowImgListLength = 0;
		let imgHdList = [];
		for (let i = 0, length = imgList.length; i < length; i++)
		{
			let lowImg = imgList[i];
			let lowSrc = imgList[i].src;
			if (lowSrc.indexOf("_small") != -1)
			{
				let imgHd = new Image();
				imgHd.onload = function()
				{
					lowImg.src = this.src;
				}
				imgHd.src = lowSrc.replace("_small", "");
			}
		}
	}
	replaceImgLowByHigh()
});