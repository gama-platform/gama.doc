[//]: # (keyword|operator_gauss)
<div class='gama-keyword-style' id ='299_0_301_operator-gauss'></div>
[//]: # (keyword|operator_distance_between)
<div class='gama-keyword-style' id ='299_1_265_operator-distance-between'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='299_2_614_statement-put'></div>
[//]: # (keyword|type_topology)
<div class='gama-keyword-style' id ='299_3_1567_type-topology'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='299_4_52_concept-gui'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='299_5_99_concept-shapefile'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='299_6_47_concept-graph'></div>
# Ville 4 ## {#ville-4}


_Author : _

Creation of buildings and roads thanks to a shape file. The color of the building depends on the type of the building, while the color of a house depend on its income. People among the world will try to find the best building according to the mean income of their neighbors and their own income, but also to their working place.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_4\carte_principale-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_4\carte_principale-10.png){.img-responsive}

Code of the model : 

```
model ville

global {
	file shape_file_batiments <- file("../includes/batiments.shp");
	file shape_file_routes <- file("../includes/routes.shp");
	geometry shape <- envelope(shape_file_routes);
	graph<point, route> reseau_route;
	init {
		create route from: shape_file_routes;
		reseau_route <- as_edge_graph(route);
		create batiment from: shape_file_batiments with: [type:: string(read("NATURE"))];
		create foyer number: 500;
	}
}
species foyer {
	float revenu <- gauss(1500, 500);
	bool est_satisfait update: calculer_satisfaction();
	batiment habitation;
	batiment lieu_travail;
	init {
		lieu_travail <- one_of(batiment where (each.type = "Industrial"));
		habitation <- choisir_batiment(); 
		do emmenager;
	}
	bool calculer_satisfaction {
		list<foyer> voisins <- foyer at_distance 50.0;
		float revenu_moyen <- mean(voisins collect (each.revenu));
		return empty(voisins) or (revenu_moyen > (revenu * 0.7) and revenu_moyen < (revenu / 0.7));
	}
	action emmenager {
		habitation.capacite <- habitation.capacite - 1;
		location <- any_location_in(habitation.shape);
	}
	action demenager {
		habitation.capacite <- habitation.capacite + 1;
	}
	batiment choisir_batiment {
		return one_of(batiment where ((each.capacite >0) and ( each.distances[lieu_travail]< 1000.0)));
	}
	reflex demenagement when: !est_satisfait {
		do demenager;
		habitation <- choisir_batiment();
		do emmenager;
	}
	aspect revenu {
		int val <- int(255 * (revenu / 3000));
		draw circle(5) color: rgb(255 - val, val, 0);
	}
}
species batiment {
	string type;
	int capacite <- type = "Industrial" ? 0 : int(shape.area / 70.0);
	map<batiment,float> distances;
	init {
		loop bat over: batiment where (each.type = "Industrial") {
			put (topology(reseau_route) distance_between [self,bat]) at: bat in: distances;
		}
	}
	aspect geometrie {
		draw shape color: type = "Industrial" ? #pink : #gray;
	}
}
species route {
	aspect geometrie {
		draw shape color: #black;
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