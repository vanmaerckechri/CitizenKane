document.addEventListener("DOMContentLoaded", function(event)
{
	let alertCookies = document.getElementById("alertCookies");
	if (sessionStorage.getItem("alertCookies") === null)
	{
		let alertCookiesCloseBtn = document.getElementById("alertCookiesCloseBtn");
		alertCookiesCloseBtn.onclick = function()
		{
			alertCookies.remove();
			sessionStorage.setItem("alertCookies", true);
		}
	}
	else
	{
		alertCookies.remove();
	}
});