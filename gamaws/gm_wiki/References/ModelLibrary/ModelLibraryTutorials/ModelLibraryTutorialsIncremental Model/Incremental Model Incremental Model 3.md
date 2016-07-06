[//]: # (keyword|operator_among)
<div class='gama-keyword-style' id ='248_0_171_operator-among'></div>
[//]: # (keyword|constant_#minute)
<div class='gama-keyword-style' id ='248_1_1291_constant--minute'></div>
[//]: # (keyword|constant_#m)
<div class='gama-keyword-style' id ='248_2_1270_constant--m'></div>
[//]: # (keyword|constant_#km)
<div class='gama-keyword-style' id ='248_3_1246_constant--km'></div>
[//]: # (keyword|concept_gis)
<div class='gama-keyword-style' id ='248_4_45_concept-gis'></div>
# Integration of GIS Data ## {#integration-of-gis-data}


third part of the tutorial : Incremental Model


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 3\chart-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 3\chart-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 3\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Incremental Model\Incremental Model Incremental Model 3\map-10.png){.img-responsive}

Code of the model : 

```

model model3 
 
global {
	int nb_people <- 500;
	float step <- 1 #minutes;
	float infection_distance <- 2.0 #m;
	float proba_infection <- 0.05;
	int nb_infected_init <- 5;
	file roads_shapefile <- file("../includes/road.shp");
	file buildings_shapefile <- file("../includes/building.shp");
	geometry shape <- envelope(roads_shapefile);
	int current_hour update: (cycle / 60) mod 24;
	int nb_people_infected <- nb_infected_init update: people count (each.is_infected);
	int nb_people_not_infected <- nb_people - nb_infected_init update: nb_people - nb_people_infected;
	
	float infected_rate update: nb_people_infected/length(people);
	init {
		create road from: roads_shapefile;
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
		
	reflex move{
		do wander;
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
}

species road {
	aspect geom {
		draw shape color: #black;
	}
}

species building {
	aspect geom {
		draw shape color: #gray;
	}
}

experiment main_experiment type:gui{
	parameter "Infection distance" var: infection_distance;
	parameter "Proba infection" var: proba_infection min: 0.0 max: 1.0;
	parameter "Nb people infected at init" var: nb_infected_init ;
	output {
		monitor "Current hour" value: current_hour;
		monitor "Infected people rate" value: infected_rate;
		display map {
			species road aspect:geom;
			species building aspect:geom;
			species people aspect:circle;			
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