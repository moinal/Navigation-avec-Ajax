(function(){

	// les éléments cibles du listener (les liens du menu) :
	var elem = document.querySelector("body header nav ul" )
	//console.log(location);
 	elem.addEventListener("click",function(e){

		e.preventDefault(); // court-circuite le comportement par défaut, dans notre cas l'accès au lien
		if (e.target.nodeName == 'A') {
			//console.log(e.target);
			fetch("/page.php",
				{
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json'
					},
					method: "POST",
					body: JSON.stringify({page: e.target.dataset.page})
				})
				.then(function(response) {
					var contentType = response.headers.get("content-type");
					//console.log(contentType);
					if(contentType && contentType.indexOf("application/json") !== -1) {
						return response.json().then(function(O_json) {
							// console.log(O_json);
							updatePage(O_json);
							history.pushState({O_json, title: O_json.Titre},null, O_json.Url);
						});
					} else {
						console.log("Oops, nous n'avons pas du JSON!");
					}

				})
				.catch(function() {
					console.log("Erreur !");
				});


		}
		e.stopPropagation();

	},false);


})();

function updatePage(O_jo){
/* Mise à jour des éléments visés*/
	document.getElementById("titrePage").innerHTML = O_jo.Titre;
    document.getElementById("content").innerHTML = O_jo.Section;
	document.getElementById("mode").innerHTML = "Avec Ajax";
}


window.onpopstate = function(event) {
	if(event.state != null){
		console.log("event.state");
		console.log(event.state);
		updatePage(event.state.O_json);
		document.getElementById("mode").innerHTML = "Avec l'historique";
	}

};
