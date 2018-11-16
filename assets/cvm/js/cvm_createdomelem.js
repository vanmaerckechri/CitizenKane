 "use strict";

// tag = ["", "", ...]
// attributeType = [[], [], ...]
// attributeValue = [[], [], ...]
let createElem = function(tag, attributeType, attributeValue)
{
	let parent;
	let lastElem;
	for (let i = tag.length - 1; i >= 0; i--)
	{
		let element = document.createElement(tag[i]);
		for (let j = attributeType[i].length - 1; j >= 0; j--)
		{
			if (attributeType[i][j] != "content")
			{
				element.setAttribute(attributeType[i][j], attributeValue[i][j])
			}
			else
			{
				element.innerText = attributeValue[i][j];
			}
		}
		// appendChild after the first iteration if we have more than 1 tag
		if (tag.length > 1 && i != tag.length - 1)
		{
			lastElem = lastElem.appendChild(element);
		}
		else
		{
			parent = element;
			lastElem = element;
		}
	}
	return parent;
};
/* 	
	HTML:

    <script type="text/javascript" src="assets/cvm/js/cvm_createdomelem.js"></script>

    Javascript:

	solo tag =>
    let newElem = createElem(["a"], [["href", "class", "content"]], [["www.test.com", "grandchildrenClass", "lien"]]);
    multi tag =>
    let newElem = createElem(["a", "p", "div", "div"], [["href", "class", "content"], ["class"], ["id", "class"], ["id", "class"]], [["www.test.com", "grandchildrenClass", "lien"], ["childClass"], ["parentId", "parentClass anotherClass"], ["grandparentId", "grandparentClass"]]);

	document.body.appendChild(newElem)
*/