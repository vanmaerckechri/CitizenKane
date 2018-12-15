class Tools
{
	static createElem(tag, attributeType, attributeValue)
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
	}

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

	static checkObjectNotEmpty(object)
	{
		let result = false;
		for (let property in object)
		{
			result = true;
		}
		return result;
	}

	static incrStr(str)
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

	static checkDup(array, string)
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

	static fixDupTitle(className, item)
	{
		let title = item.value;
		if (title != 0)
		{
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

			while (this.checkDup(carteTitleList , title))
			{
				title = this.incrStr(title);
			}
			item.value = title;
		}
		return title;
	}
}