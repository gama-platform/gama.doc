[//]: # (keyword|operator_gauss)
<div class='gama-keyword-style' id ='297_0_301_operator-gauss'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='297_1_52_concept-gui'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='297_2_99_concept-shapefile'></div>
# Ville 2 ## {#ville-2}


_Author : _

Creation of buildings and roads thanks to a shape file. The color of the building depends on the type of the building, while the color of a house depend on its income. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_2\carte_principale-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_2\carte_principale-10.png){.img-responsive}

Code of the model : 

```

model ville

global {
	file shape_file_batiments <- file("../includes/batiments.shp");
	file shape_file_routes <- file("../includes/routes.shp");
	geometry shape <- envelope(shape_file_routes);
	init {
		create route from: shape_file_routes;
		create batiment from: shape_file_batiments with: [type:: string(read("NATURE"))];
		create foyer number: 500;
	}
}

species batiment {
	string type;
	int capacite <- type = "Industrial" ? 0 : int(shape.area / 60.0);
	aspect geometrie {
		draw shape color: type = "Industrial" ? #pink : #gray;
	}
}

species route {
	aspect geometrie {
		draw shape color: #black;
	}
}

species foyer {
	float revenu <- gauss(1500, 500);
	batiment habitation;
	batiment lieu_travail;
	
	aspect revenu {
		int val <- int(255 * (revenu / 3000));
		draw circle(5) color: rgb(255 - val, val, 0);
	}
}

experiment ville type: gui {
	output {
		display carte_principale {
			species batiment aspect: geometrie;
			species route aspect: geometrie;
			species foyer aspect: revenu;
		}
	}
}
```