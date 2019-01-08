 "use strict";

document.addEventListener("DOMContentLoaded", function(event)
{
	let compareInputs = function(form, input1, input2, submitBtn)
	{
		if (input1.value != input2.value)
		{
			if (!form.classList.contains("inputRepeat-error"))
			{
				form.classList.remove("inputRepeat-correct");
				form.classList.add("inputRepeat-error");
				submitBtn.classList.add("displayNone");
			}
		}
		else
		{
			if (form.classList.contains("inputRepeat-error") && input1.value != "")
			{
				form.classList.remove("inputRepeat-error");
				form.classList.add("inputRepeat-correct");
				submitBtn.classList.remove("displayNone");
			}
		}
	}

	let initInputRepeat = function()
	{
		let form = document.querySelectorAll(".inputRepeat-form");
		for (let i = form.length - 1; i >= 0; i--)
		{
			let input1 = form[i].querySelector(".inputRepeat-input1");
			let input2 = form[i].querySelector(".inputRepeat-input2");

			let submitBtn = form[i].querySelector(".inputRepeat-submit");
			submitBtn.classList.add("displayNone");

			form[i].onkeypress = function(e)
			{
				let key = e.charCode || e.keyCode || 0;     
				if (key == 13)
				{
					e.preventDefault();
					if (!form[i].classList.contains("inputRepeat-error"))
					{
						form[i].submit();
					}
				}
			}

			input1.addEventListener("input", compareInputs.bind(this, form[i], input1, input2, submitBtn), false);
			input2.addEventListener("input", compareInputs.bind(this, form[i], input1, input2, submitBtn), false);
		}
	}

	initInputRepeat();
});

/* 	
	(sass: "assets/cvm/sass/_inputRepeat.scss")

	HTML:

	<link rel="stylesheet" href="assets/cvm/css/cvm_style.css">

	<div id="repeat01">
		<input type="password" name="pwd" required>
	</div>

	<div class="pwdStrength-container target_repeat01">
		<input type="password" name="pwd" required>
	</div>

    <script type="text/javascript" src="assets/cvm/js/cvm_inputRepeat.js"></script>
*/


