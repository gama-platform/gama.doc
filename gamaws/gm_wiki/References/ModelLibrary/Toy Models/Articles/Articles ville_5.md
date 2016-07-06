[//]: # (keyword|operator_gauss)
<div class='gama-keyword-style' id ='300_0_301_operator-gauss'></div>
[//]: # (keyword|operator_distance_between)
<div class='gama-keyword-style' id ='300_1_265_operator-distance-between'></div>
[//]: # (keyword|statement_remove)
<div class='gama-keyword-style' id ='300_2_618_statement-remove'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='300_3_614_statement-put'></div>
[//]: # (keyword|type_topology)
<div class='gama-keyword-style' id ='300_4_1567_type-topology'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='300_5_52_concept-gui'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='300_6_99_concept-shapefile'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='300_7_47_concept-graph'></div>
# Ville 5 ## {#ville-5}


_Author : _

Creation of buildings and roads thanks to a shape file. The color of the building depends on the type of the building, while the color of a house depend on its income. People among the world will try to find the best building according to the mean income of their neighbors and their own income, but also to their working place. This model add a new display showing the "color" of each building according to the mean income of its residents


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_5\carte_batiment-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_5\carte_batiment-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_5\carte_principale-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_5\carte_principale-10.png){.img-responsive}

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
		habitation.foyers << self;
		location <- any_location_in(habitation.shape) + {0,0, habitation.hauteur};
	}
	action demenager {
		habitation.capacite <- habitation.capacite + 1;
		remove self from: habitation.foyers;
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
		draw sphere(5) color: rgb(255 - val, val, 0);
	}
}
species batiment {
	string type;
	int capacite <- type = "Industrial" ? 0 : int(shape.area / 70.0);
	map<batiment,float> distances;
	int hauteur <- 5 + rnd(10);
	list<foyer> foyers ;
	float revenu_moyen update: empty(foyer) ? 0.0 : mean (foyers collect each.revenu);
	init {
		loop bat over: batiment where (each.type = "Industrial") {
			put (topology(reseau_route) distance_between [self,bat]) at: bat in: distances;
		}
	}
	aspect geometrie {
		draw shape color: type = "Industrial" ? #pink : #gray depth: hauteur;
	}
	aspect information_foyer {
		draw shape color: type = "Industrial" ? #pink : (empty(foyers) ? #gray : rgb(int(255 * (1 - (revenu_moyen / 3000))), int(255 * (revenu_moyen / 3000)), 0)) depth: length(foyers);
	}
}
species route {
	aspect geometrie {
		draw shape color: #black;
	}
}
experiment ville type: gui {
	output {
		display carte_principale type: java2D {
			species batiment aspect: geometrie;
			species route aspect: geometrie;
			species foyer aspect: revenu;
		}
		display carte_batiment type: opengl {
			species batiment aspect: information_foyer;
		}
	}
}
```