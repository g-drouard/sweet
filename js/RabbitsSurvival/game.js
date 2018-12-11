	var divGameLeft = $('#game-div-left'),
			navGameMenu = divGameLeft.find('#nav-game-menu'),
			navGameMenuLi = divGameLeft.find('#nav-game-menu li'),
			divGameRight = $('#game-div-right'),
			resourceCarrot = $('#resource-carrot'),
			resourceWater = $('#resource-water'),
			resourceWood = $('#resource-wood'),
			resourceStone = $('#resource-stone'),
			gameContent = divGameRight.find('.game-content');
	
	jQuery(document).ready(function($){
		
		function getNavGameMenuActive(){
			return navGameMenu.find('.active').index();
		}
		
		function resetNavGameMenu(){
			navGameMenu.find('.active').removeClass('active');
		}
		
		function changeGameDisplay(id){
			var newId = id.concat("-content");
			gameContent.attr("id",newId);
		}
		
		function changeGameContent(index){
			switch(index){
				case 0:
				
				changeHole();
				break;
				
				case 1:
				
				changeForest();
				break;
				
				case 2:
				
				changeMine();
				break;
				
				case 3:
				
				changeRiver();
				break;
				
				case 4:
				
				changePotager();
				break;
				
				case 5:
				
				changeLaboratory();
				break;
				
				case 6:
				
				changeSite();
				break;
				
				case 7:
				
				changeWorkroom();
				break;
			}
		}
		
		navGameMenuLi.on('click', function(event){
			if($(this).index() != getNavGameMenuActive())
			{
				resetNavGameMenu();
				$(this).addClass('active');
				changeGameContent($(this).index());
				changeGameDisplay($(this)[0].id);
			}
		});
		
		function changeHole(){
			gameContent.html("");
		}

		function changeForest(){
			gameContent.html("<input type='button' value='Ajouter Bois' onclick='javascript:addResources(1,2);' />");
		}
		
		function changeMine(){
			gameContent.html("<input type='button' value='Ajouter Pierre' onclick='javascript:addResources(1,3);' />");
		}
		
		function changeRiver(){
			gameContent.html("<input type='button' value='Ajouter Eau' onclick='javascript:addResources(1,1);' />");
		}
		
		function changePotager(){
			gameContent.html("<input type='button' value='Ajouter Carotte' onclick='javascript:addResources(1,0);' />");
		}
		
		function changeLaboratory(){
			gameContent.html("");
		}
		
		function changeSite(){
			gameContent.html("");
		}
		
		function changeWorkroom(){
			gameContent.html("");
		}
	});
	
	var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
	
	function getXhr(){
						var xhr = null; 
		if(window.XMLHttpRequest) // Firefox et autres
		   xhr = new XMLHttpRequest(); 
		else if(window.ActiveXObject){ // Internet Explorer 
		   try {
					xhr = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
		}
		else { // XMLHttpRequest non supporté par le navigateur 
		   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		   xhr = false; 
		} 
						return xhr
	}

	/* Adding resource */
	
	function addResources(quantity,resource_id){
		var xhr = getXhr();
		var params = "level_id=".concat(getUrlParameter('level_id')).concat("&quantity=").concat(quantity).concat("&resource_id=").concat(resource_id);
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				switch (resource_id) {
					
					case 0:
					
					resourceCarrot.text(xhr.responseText);
					break;
					
					case 1:
					
					resourceWater.text(xhr.responseText);
					break;
					
					case 2:
					
					resourceWood.text(xhr.responseText);
					break;
					
					case 3:
					
					resourceStone.text(xhr.responseText);
					break;
				}
			}
		}
		xhr.open("POST","resourcesProcessing.php",true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(params);
	}