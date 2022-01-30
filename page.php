<?php

if(file_get_contents('php://input') != ""){
	//On reçoit du Json, par déduction :  Ajax

	$content = file_get_contents('php://input'); // récupération du contenu JSON
	$decoded = json_decode($content, true); // Transformation en un tableau php

	//JSON à retourner
    $S_data = '';
	switch( $decoded['page']){
		case '1':
			$S_data = [
				"Titre" => "Page 1",
				"Section" => "<p>Contenu  Page 1</p>",
				"Url" => "page.php?id=1"
            ];
		break;
		case '2':
            $S_data =[
				"Titre" => "Page 2",
				"Section" => "<p>Contenu  Page 2</p>",
				"Url" => "page.php?id=2"
			];
		break;
		case '3':
            $S_data =[
				"Titre"=> "Page 3",
				"Section"=> "<p>Contenu  Page 3</p>",
				"Url"=> "page.php?id=3"
            ];
		break;
	}
    header('Content-Type: application/json;');
    echo json_encode( $S_data );
    exit();
}else{
	// On reçoit un get, pas d'ajax
    // page 1 par défaut
    $Titre = "Page 1";
    $Section =  "<p>Contenu  Page 1</p>";
    if (isset($_GET['id'])){
    switch( $_GET['id']){

		case 2:
		    $Titre = "Page 2";
		    $Section =  "<p>Contenu  Page 2</p>";

		break;
		case 3:
            $Titre = "Page 3";
            $Section =  "<p>Contenu  Page 3</p>";
		break;

	    }
    }


echo <<<HERE
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo Ajax</title>
     <script src="js/init.js" async></script>
  </head>
  <body>
    <header>
      <h1 id="mode">Avec un GET classique</h1>
			<!-- Sans Aria nous pourrions forcer le focus sur le h1, préférable dans certaines situations -  multiple zones et éviter plsuieurs aria-atomic-->
	    <h2 id='titrePage'>$Titre</h2>
	    <!-- https://www.w3.org/TR/wai-aria-practices/
	      https://disic.github.io/guide-developpeur/9-utiliser-aria.html -->
      <nav>
        <ul>
          <li><a href="page.php?id=1" data-page="1" >page1</a></li>
          <li><a href="page.php?id=2" data-page="2" >page2</a></li>
          <li><a href="page.php?id=3" data-page="3" >page3</a></li>
        </ul>
      </nav>
    </header>


    <section id ="content" aria-live="polite" aria-atomic="true" aria-relevant="all">$Section</section>

 
    <script>
    </script>
   </body>
 </html>
HERE;
}
