[//]: # (keyword|operator_in)
<div class='gama-keyword-style' id ='207_0_328_operator-in'></div>
[//]: # (keyword|operator_as_matrix)
<div class='gama-keyword-style' id ='207_1_193_operator-as-matrix'></div>
[//]: # (keyword|operator_kappa)
<div class='gama-keyword-style' id ='207_2_365_operator-kappa'></div>
[//]: # (keyword|operator_kappa_sim)
<div class='gama-keyword-style' id ='207_3_366_operator-kappa-sim'></div>
[//]: # (keyword|operator_fuzzy_kappa)
<div class='gama-keyword-style' id ='207_4_297_operator-fuzzy-kappa'></div>
[//]: # (keyword|operator_fuzzy_kappa_sim)
<div class='gama-keyword-style' id ='207_5_298_operator-fuzzy-kappa-sim'></div>
[//]: # (keyword|operator_percent_absolute_deviation)
<div class='gama-keyword-style' id ='207_6_424_operator-percent-absolute-deviation'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='207_7_614_statement-put'></div>
[//]: # (keyword|statement_using)
<div class='gama-keyword-style' id ='207_8_642_statement-using'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='207_9_1556_type-matrix'></div>
[//]: # (keyword|type_topology)
<div class='gama-keyword-style' id ='207_10_1567_type-topology'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='207_11_51_concept-grid'></div>
[//]: # (keyword|concept_comparison)
<div class='gama-keyword-style' id ='207_12_22_concept-comparison'></div>
[//]: # (keyword|concept_raster)
<div class='gama-keyword-style' id ='207_13_91_concept-raster'></div>
[//]: # (keyword|concept_statistic)
<div class='gama-keyword-style' id ='207_14_108_concept-statistic'></div>
# Raster Map Comparison ## {#raster-map-comparison}


_Author : Patrick Taillandier_

This model shows how to use different comparators to know the accuracy of a prediction model. Four comparators are used :
- kappa, comparing the map observed and the map simulation ; kappa simulation comparing the initial map, the map observed and the map simulation;
- fuzzy kappa, comparing the map observed and the map simulation but being more permissive by using fuzzy logic;
- fuzzy kappa simulation, comparing the map observed, the map simulation and the map initial but being more permissive by using fuzzy logic


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_fuzzy-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_fuzzy-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_init-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_init-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_observed-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_observed-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_sim-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Raster Map Comparison\map_sim-10.png){.img-responsive}

Code of the model : 

```

model mapcomparison

global {
	list<string> categories <- ["type 1", "type 2", "type 3", "type 4"];
	map<string,rgb> color_cat <- ["type 1"::#blue, "type 2"::#green, "type 3"::#yellow, "type 4"::#red];
	matrix<float> fuzzy_categories;
	matrix<float> fuzzy_transitions;
	list<float> nb_per_cat_obs;
	list<float> nb_per_cat_sim;
	 
	init {
		//Initialize randomly the category of each cell
		ask shuffle(cell) {
			string neigh_cat <-one_of(neighbours).cat_observed;
			cat_init <- neigh_cat in categories ? neigh_cat : one_of(categories);
			color_init <- color_cat[cat_init];
		}
		
		//Initialize the category observed and the cat attributes of the cells according to probability : 
		// 60% of cases, the category observed will be the same than the category initialized
		//60% of cases, the category will be the same than the category observed
		ask cell {
			cat_observed <- flip(0.6) ?  cat_init : one_of(categories);
			cat <- flip(0.6) ?  cat_observed : one_of(categories);
			color <- color_cat[cat];
			color_obs <- color_cat[cat_observed];
		}
		fuzzy_categories <- 0.0 as_matrix {length(categories),length(categories)};
		loop i from: 0 to: length(categories) - 1 {
			fuzzy_categories[i,i] <- 1.0;
		}
		fuzzy_transitions <- 0.0 as_matrix {length(categories)*length(categories),length(categories)*length(categories)};
		loop i from: 0 to: (length(categories) * length(categories)) - 1 {
			fuzzy_transitions[i,i] <- 1.0;	
		}
		list<float> similarity_per_agents <- [];
		write "kappa(map observed, map simulation, categories): " + kappa( cell collect (each.cat_observed),cell collect (each.cat),categories);
		write "kappa simulation(map init, map observed, map simulation,categories): " + kappa_sim( cell collect (each.cat_init), cell collect (each.cat_observed),cell collect (each.cat),categories);
		using topology(cell) {
			write "fuzzy kappa(map observed, map simulation,categories): " + fuzzy_kappa(list(cell), cell collect (each.cat_observed),cell collect (each.cat), similarity_per_agents,categories,fuzzy_categories, 10);
			write "fuzzy kappa sim(map init, map observed, map simulation,categories): " + fuzzy_kappa_sim(list(cell), cell collect (each.cat_init), cell collect (each.cat_observed),cell collect (each.cat), similarity_per_agents,categories,fuzzy_transitions, 10);
		}
		loop i from: 0 to: length(cell) - 1 {
			int val <- int(255 * similarity_per_agents[i]);
			ask cell[i] {color_fuzzy <- rgb(val, val, val);}
			
		}
		loop c over: categories {
			nb_per_cat_obs << cell count (each.cat_observed = c);
			nb_per_cat_sim << cell count (each.cat = c); 
		}
		write "percent_absolute_deviation : " + percent_absolute_deviation(nb_per_cat_obs,nb_per_cat_sim) + "%";
		
	}
	
}

grid cell width: 50 height: 50 {
	string cat_init;
	string cat_observed;
	string cat ;
	rgb color;
	rgb color_init;
	rgb color_obs;
	rgb color_fuzzy <- #white;
	list<cell> neighbours <- self neighbors_at 1;
	
	aspect fuzzy_sim {
		draw shape color:color_fuzzy border: color_fuzzy;
	}
	aspect init {
		draw shape color:color_init border: color_init;
	}
	aspect observed {
		draw shape color:color_obs border: color_obs;
	}
}

experiment mapcomparison type: gui {
	output {
		display map_sim type: opengl{
			grid cell;
		}
		display map_observed type: opengl{
			species cell aspect: observed refresh: false;
		}
		display map_init type: opengl{
			species cell aspect: init refresh: false;
		}
		display map_fuzzy type: opengl{
			species cell aspect: fuzzy_sim ;
		}
	}
}

```