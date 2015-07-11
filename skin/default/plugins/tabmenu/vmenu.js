<!--
function showSubMenu(){
	var objThis = this;	
	for(var i = 0; i  < objThis.childNodes.length; i++)
	{
		if((objThis.childNodes.item(i).nodeName == "UL")&&(objThis.childNodes.item(i).className == "ulVMenu"))			
		{							
			objThis.childNodes.item(i).style.display = "block";		
		}		
	}	
}

function hideSubMenu()
{								
	var objThis = this;	
	for(var i = 0; i  < objThis.childNodes.length; i++)			
	{
		if((objThis.childNodes.item(i).nodeName == "UL")&&(objThis.childNodes.item(i).className == "ulVMenu"))
		{				
			objThis.childNodes.item(i).style.display = "none";			
			return;
		}			
	}	
}			

function initialiseMenu()
{
	var objLICollection = document.body.getElementsByTagName("LI");		
	for(var i = 0; i < objLICollection.length; i++)
	{		
		var objLI = objLICollection[i];		
		for(var j = 0; j  < objLI.childNodes.length; j++)
		{
			if((objLI.childNodes.item(j).nodeName == "UL")&&(objLI.childNodes.item(j).className == "ulVMenu"))
			{
				objLI.onmouseover=showSubMenu;
				objLI.onmouseout=hideSubMenu;
				objLI.childNodes.item(j).style.display = "none";
				for(var j = 0; j  < objLI.childNodes.length; j++)
				{
					if(objLI.childNodes.item(j).nodeName == "A")
					{					
						objLI.childNodes.item(j).className = "hassubmenu";								
					}
				}
			}
		}
	}
}
-->