[//]: # (keyword|operator_^)
<div class='gama-keyword-style' id ='250_0_139_operator--'></div>
[//]: # (keyword|operator_abs)
<div class='gama-keyword-style' id ='250_1_149_operator-abs'></div>
[//]: # (keyword|operator_among)
<div class='gama-keyword-style' id ='250_2_171_operator-among'></div>
[//]: # (keyword|constant_#minute)
<div class='gama-keyword-style' id ='250_3_1291_constant--minute'></div>
[//]: # (keyword|constant_#m)
<div class='gama-keyword-style' id ='250_4_1270_constant--m'></div>
[//]: # (keyword|constant_#km)
<div class='gama-keyword-style' id ='250_5_1246_constant--km'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='250_6_1_concept-3d'></div>
[//]: # (keyword|concept_light)
<div class='gama-keyword-style' id ='250_7_63_concept-light'></div>
# 3D visualization ## {#3d-visualization}


5th part of the tutorial : Incremental Model


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 5\chart-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 5\chart-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 5\map_3D-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 5\map_3D-10.png){.img-responsive}

Code of the model : 

```

model model5 
 
global {
	int nb_people <- 500;
	float step <- 1 #minutes;
	float infection_distance <- 2.0 #m;
	float proba_infection <- 0.05;
	int nb_infected_init <- 5;
	file roads_shapefile <- file("../includes/road.shp");
	file buildings_shapefile <- file("../includes/building.shp");
	geometry shape <- envelope(roads_shapefile);
	graph road_network;
	int current_hour update: (cycle / 60) mod 24;
	float staying_coeff update: 10.0 ^ (1 + min([abs(current_hour - 9), abs(current_hour - 12), abs(current_hour - 18)]));
	int nb_people_infected <- nb_infected_init update: people count (each.is_infected);
	int nb_people_not_infected <- nb_people - nb_infected_init update: nb_people - nb_people_infected;
	bool is_night <- true update: current_hour < 7 or current_hour > 20;
	
	float infected_rate update: nb_people_infected/length(people);
	init {
		create road from: roads_shapefile;
		road_network <- as_edge_graph(road);
		create building from: buildings_shapefile;
		create people number:nb_people {
			speed <- 5.0 #km/#h;
			building bd <- one_of(building);
			location <- any_location_in(bd);
		}
		ask nb_infected_init among people {
			is_infected <- true;
		}
	}
	reflex end_simulation when: infected_rate = 1.0 {
		do halt;
	}
}

species people skills:[moving]{		
	bool is_infected <- false;
	point target;
	int staying_counter;
	reflex stay when: target = nil {
		staying_counter <- staying_counter + 1;
		if flip(staying_counter / staying_coeff) {
			target <- any_location_in (one_of(building));
		}
	}
		
	reflex move when: target != nil{
		do goto target:target on: road_network;
		if (location = target) {
			target <- nil;
			staying_counter <- 0;
		} 
	}
	reflex infect when: is_infected{
		ask people at_distance infection_distance {
			if flip(proba_infection) {
				is_infected <- true;
			}
		}
	}
	aspect circle{
		draw circle(5) color:is_infected ? #red : #green;
	}
	aspect sphere3D{
		draw sphere(3) at: {location.x,location.y,location.z + 3} color:is_infected ? #red : #green;
	}
}

species road {
	geometry display_shape <- shape + 2.0;
	aspect geom {
		draw display_shape color: #black depth: 3.0;
	}
}

species building skills:[moving] {
	float height <- 10#m + rnd(10) #m;
	aspect geom {
		draw shape color: #gray depth: height;
	}
}

experiment main_experiment type:gui{
	parameter "Infection distance" var: infection_distance;
	parameter "Proba infection" var: proba_infection min: 0.0 max: 1.0;
	parameter "Nb people infected at init" var: nb_infected_init ;
	output {
		monitor "Current hour" value: current_hour;
		monitor "Infected people rate" value: infected_rate;
		display map_3D type: opengl ambient_light: is_night ? 20 : 50 diffuse_light: is_night ? 60 : 110 {
			image "../includes/soil.jpg";
			species road aspect:geom;
			species people aspect:sphere3D;			
			species building aspect:geom transparency: 0.5;
		}
		display chart refresh: every(10) {
			chart "Disease spreading" type: series {
				data "susceptible" value: nb_people_not_infected color: #green;
				data "infected" value: nb_people_infected color: #red;
			}
		}
	}
}
```