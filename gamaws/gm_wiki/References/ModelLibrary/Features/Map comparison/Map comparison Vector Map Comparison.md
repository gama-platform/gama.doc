[//]: # (keyword|operator_not)
<div class='gama-keyword-style' id ='208_0_405_operator-not'></div>
[//]: # (keyword|operator_in)
<div class='gama-keyword-style' id ='208_1_328_operator-in'></div>
[//]: # (keyword|operator_as_matrix)
<div class='gama-keyword-style' id ='208_2_193_operator-as-matrix'></div>
[//]: # (keyword|operator_kappa)
<div class='gama-keyword-style' id ='208_3_365_operator-kappa'></div>
[//]: # (keyword|operator_kappa_sim)
<div class='gama-keyword-style' id ='208_4_366_operator-kappa-sim'></div>
[//]: # (keyword|operator_fuzzy_kappa)
<div class='gama-keyword-style' id ='208_5_297_operator-fuzzy-kappa'></div>
[//]: # (keyword|operator_fuzzy_kappa_sim)
<div class='gama-keyword-style' id ='208_6_298_operator-fuzzy-kappa-sim'></div>
[//]: # (keyword|operator_sum)
<div class='gama-keyword-style' id ='208_7_512_operator-sum'></div>
[//]: # (keyword|operator_percent_absolute_deviation)
<div class='gama-keyword-style' id ='208_8_424_operator-percent-absolute-deviation'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='208_9_614_statement-put'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='208_10_1556_type-matrix'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='208_11_99_concept-shapefile'></div>
[//]: # (keyword|concept_comparison)
<div class='gama-keyword-style' id ='208_12_22_concept-comparison'></div>
[//]: # (keyword|concept_statistic)
<div class='gama-keyword-style' id ='208_13_108_concept-statistic'></div>
# Vector Map Comparison ## {#vector-map-comparison}


_Author : Patrick Taillandier_

This model shows how to use different comparators to know the accuracy of a prediction model. Four comparators are used :
- kappa, comparing the map observed and the map simulation ; kappa simulation comparing the initial map, the map observed and the map simulation;
- fuzzy kappa, comparing the map observed and the map simulation but being more permissive by using fuzzy logic;
- fuzzy kappa simulation, comparing the map observed, the map simulation and the map initial but being more permissive by using fuzzy logic
For each comparator, two comparisons are made : one without taking into account the weights of an area, just computing with each area having the same importance, and an other using weights related to the area of the region


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_fuzzy-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_fuzzy-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_init-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_init-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_observed-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_observed-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_sim-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Map comparison\Map comparison Vector Map Comparison\map_sim-10.png){.img-responsive}

Code of the model : 

```

model mapcomparison

global {
	list<string> categories ;
	map<string,rgb> color_cat ;
	matrix<float> fuzzy_categories;
	matrix<float> fuzzy_transitions;
	list<float> nb_per_cat_obs;
	list<float> nb_per_cat_sim;
	file data <- file("../includes/CLC00_06.shp");
	
	geometry shape <- envelope(data);
	 
	init {
		create areaclc from: data with: [init_cover::string(read("CODE_00")),obs_cover::string(read("CODE_06"))] ;
		ask areaclc {
			if (not (init_cover in categories)) {categories << init_cover; }
			if (not (obs_cover in categories)) {categories << obs_cover;}
			
		}
		loop cat over: categories {
			color_cat[cat] <- rgb(rnd(255),rnd(255),rnd(255));
		}
		ask areaclc {
			sim_cover <- flip(0.7) ? obs_cover : one_of (categories);
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
		write "kappa(map observed, map simulation, categories): " + kappa( areaclc collect (each.obs_cover),areaclc collect (each.sim_cover),categories);
		write "kappa(map observed, map simulation,categories, weights): " + kappa( areaclc collect (each.obs_cover),areaclc collect (each.sim_cover),categories,areaclc collect (each.shape.area));
		
		write "kappa simulation(map init, map observed, map simulation, categories): " + kappa_sim( areaclc collect (each.init_cover), areaclc collect (each.obs_cover),areaclc collect (each.sim_cover),categories);
		write "kappa simulation(map init, map observed, map simulation, categories, weights): " + kappa_sim( areaclc collect (each.init_cover), areaclc collect (each.obs_cover),areaclc collect (each.sim_cover),categories,areaclc collect (each.shape.area));
		
		write "fuzzy kappa(map observed, map simulation,categories): " + fuzzy_kappa(areaclc, areaclc collect (each.obs_cover),areaclc collect (each.sim_cover), similarity_per_agents,categories,fuzzy_categories, 3000);
		write "fuzzy kappa(map observed, map simulation,categories,weights): " + fuzzy_kappa(areaclc, areaclc collect (each.obs_cover),areaclc collect (each.sim_cover), similarity_per_agents,categories,fuzzy_categories, 3000,areaclc collect (each.shape.area));
		
		write "fuzzy kappa sim(map init, map observed, map simulation,categories): " + fuzzy_kappa_sim(areaclc, areaclc collect (each.init_cover), areaclc collect (each.obs_cover),areaclc collect (each.sim_cover), similarity_per_agents,categories,fuzzy_transitions, 3000);
		write "fuzzy kappa sim(map init, map observed, map simulation,categories,weights): " + fuzzy_kappa_sim(areaclc, areaclc collect (each.init_cover), areaclc collect (each.obs_cover),areaclc collect (each.sim_cover), similarity_per_agents,categories,fuzzy_transitions, 3000,areaclc collect (each.shape.area));
		
		loop i from: 0 to: length(areaclc) - 1 {
			int val <- int(255 * similarity_per_agents[i]);
			ask areaclc[i] {color_fuzzy <- rgb(val, val, val);}
			
		}
		loop c over: categories {
			list<areaclc> area_c <- areaclc where (each.obs_cover = c);
			list<float> area_shape_c <- area_c collect (each.shape.area);
			nb_per_cat_obs << sum(area_shape_c );
			nb_per_cat_sim << sum((areaclc where (each.sim_cover = c)) collect (each.shape.area)); 
		}
		write "percent_absolute_deviation : " + percent_absolute_deviation(nb_per_cat_obs,nb_per_cat_sim) + "%";
		
	}
	
}
 
species areaclc {
	string init_cover;
	string obs_cover;
	string sim_cover;
	rgb color_fuzzy;
	
	aspect init {
		draw shape color: color_cat[init_cover];
	}
	aspect simulation {
		draw shape color: color_cat[sim_cover];
	}
	aspect observed {
		draw shape color: color_cat[obs_cover];
	}
	aspect fuzzy_sim {
		draw shape color: color_fuzzy;
	}
}


experiment mapcomparison type: gui {
	output {
		display map_sim type: opengl{
			species areaclc aspect: simulation;
		}
		display map_observed type: opengl{
			species areaclc aspect: observed refresh: false;
		}
		display map_init type: opengl{
			species areaclc aspect: init refresh: false;
		}
		display map_fuzzy type: opengl{
			species areaclc aspect: fuzzy_sim ;
		}
	}
}

```