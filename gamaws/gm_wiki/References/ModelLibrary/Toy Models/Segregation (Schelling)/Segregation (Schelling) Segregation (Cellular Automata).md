[//]: # (keyword|operator_sum)
<div class='gama-keyword-style' id ='337_0_512_operator-sum'></div>
[//]: # (keyword|operator_any)
<div class='gama-keyword-style' id ='337_1_175_operator-any'></div>
[//]: # (keyword|operator_copy)
<div class='gama-keyword-style' id ='337_2_238_operator-copy'></div>
[//]: # (keyword|statement_remove)
<div class='gama-keyword-style' id ='337_3_618_statement-remove'></div>
[//]: # (keyword|constant_#magenta)
<div class='gama-keyword-style' id ='337_4_1273_constant--magenta'></div>
[//]: # (keyword|constant_#cyan)
<div class='gama-keyword-style' id ='337_5_1189_constant--cyan'></div>
[//]: # (keyword|constant_#lightgray)
<div class='gama-keyword-style' id ='337_6_1256_constant--lightgray'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='337_7_51_concept-grid'></div>
# segregationGrid ## {#segregationgrid}


_Author : _

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Segregation (Schelling)\Segregation (Schelling) Segregation (Cellular Automata)\Charts-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Segregation (Schelling){.img-responsive}\Segregation (Schelling) Segregation (Cellular Automata)\Charts-10.png)

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Segregation (Schelling)\Segregation (Schelling) Segregation (Cellular Automata)\Segregation-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Segregation (Schelling){.img-responsive}\Segregation (Schelling) Segregation (Cellular Automata)\Segregation-10.png)

Imported model : 

```
model segregation_base

global {
	//Different colors for the group
	rgb color_1 <- rgb ("yellow") parameter: "Color of group 1:" category: "User interface";
	rgb color_2 <- rgb ("red") parameter: "Color of group 2:" category: "User interface";
	rgb color_3 <- rgb ("blue") parameter: "Color of group 3:" category: "User interface";
	rgb color_4 <- rgb ("orange") parameter: "Color of group 4:" category: "User interface";
	rgb color_5 <- rgb ("green") parameter: "Color of group 5:" category: "User interface";
	rgb color_6 <- rgb ("pink") parameter: "Color of group 6:" category: "User interface";   
	rgb color_7 <- rgb ("magenta") parameter: "Color of group 7:" category: "User interface";
	rgb color_8 <- rgb ("cyan") parameter: "Color of group 8:" category: "User interface";
	const black type: rgb <- rgb ("black");
	list colors <- [°yellow, °red, °blue, °orange, °green, °pink, °magenta, °cyan] of: rgb;
	
	//Number of groups
	int number_of_groups <- 2 max: 8 parameter: "Number of groups:" category: "Population";
	//Density of the people
	float density_of_people <- 0.7 parameter: "Density of people:" category: "Population" min: 0.01 max: 0.99;
	//Percentage of similar wanted for segregation
	float percent_similar_wanted <- 0.5 min: float (0) max: float (1) parameter: "Desired percentage of similarity:" category: "Population";
	//Dimension of the grid
	int dimensions <- 40 max: 400 min: 10 parameter: "Width and height of the environment:" category: "Environment";
	//Neighbours distance for the perception of the agents
	int neighbours_distance <- 2 max: 10 min: 1 parameter: "Distance of perception:" category: "Population";
	//Number of people agents
	int number_of_people <- 0;
	//Number of happy people
	int sum_happy_people <- 0 update: all_people count (each.is_happy);
	//Number of similar neighbours
	int sum_similar_neighbours <- 0 update: sum (all_people collect each.similar_nearby);
	//Number of neighbours
	int sum_total_neighbours <- 1 update: sum (all_people collect each.total_nearby) min: 1;
	//List of all the places
	list<agent> all_places <- [];
	//List of all the people
	list<base> all_people <- [];  
	
	//Action to write the description of the model in the console
	action description {
		write
		"\\n\\u25B6 Description. \\n\\u25B6 Thomas Schelling model of residential segregation is a classic study of the effects of local decisions on global dynamics. Agents with mild preferences for same-type neighbors, but without preferences for segregated neighborhoods, can wind up producing complete segregation.\\n\\u25B6 In this model, agents populate a grid with a given *density*. They are in two different states : happy when the percentage of same-color neighbours is above their *desired percentage of similarity*; unhappy otherwise. In the latter case, they change their location randomly until they find a neighbourhood that fits their desire. \\n\\u25B6 In addition to the previous parameter, one can adjust the *distance of perception* (i.e.  the distance at which they consider other agents as neighbours) of the agents to see how it affects the global process. ";
	}
	//Initialization of the model
	init {
		//Write the description of the model 
		do description;
		//Initialization of the places
		do initialize_places;
		//Computation of the number of people according to the density of people
		number_of_people <- int( length (all_places) * density_of_people);
		//Initialization of the people
		do initialize_people;
	}
	//Action to initialize places defined in the subclasses
	action initialize_places virtual: true;
	//Action to initialize people in the subclasses
	action initialize_people virtual: true;
}

//Species base representing the people agents
species base {
	rgb color;
	//List of all the neighbours agents
	list<base> my_neighbours;
	//computation of the similar neighbours
	int similar_nearby -> {
		(my_neighbours count (each.color = color))
	};
	//Computation of the total neighbours nearby
	int total_nearby -> {
		length (my_neighbours)
	};
	//Boolean to know if the agent is happy or not
	bool is_happy -> {similar_nearby >= (percent_similar_wanted * total_nearby )} ;
}

```


Code of the model : 

```
model segregation

//Importation of the Common Schelling Segregation model
import "../include/Common Schelling Segregation.gaml"

//Define the environment as torus
global torus: true{
	//List of all the free places
	list<space> free_places <- [] ;
	//List of all the places
	list<space> all_places <- [] ;
	//List of all the people
	list<space> all_people <- [];
	//Shape of the environment
	geometry shape <- square(dimensions);
	
	//Action to initialize the places
	action initialize_places {
		set all_places <- shuffle(space);
		set free_places <- shuffle(all_places);
	}
	//Action to initialize the people agents
	action initialize_people {
		//Place all the people agent in the cellular automata
		loop i from: 0 to: number_of_people - 1 {
			space pp <- all_places at i;
			remove pp from: free_places;
			add pp to: all_people;
			pp.color <- colors at (rnd(number_of_groups - 1));
		}

	}
	//Reflex to migrate all the people agents
	reflex migrate {
		ask copy(all_people) {
			do migrate;
		}

	}

}

//Grid species representing the places and the people in each cell
grid space parent: base width: dimensions height: dimensions neighbors: 8  {
	rgb color <- black;
	//List of the neighbours of the places
	list<space> my_neighbours <- self neighbors_at neighbours_distance;
	//Action to migrate the agent in another cell if it is not happy
	action migrate {
		if !is_happy {
			//Change the space of the agent to a free space
			space pp <- any(my_neighbours where (each.color = black));
			if (pp != nil) {
				free_places <+ self;
				free_places >- pp;
				all_people >- self;
				all_people << pp;
				set pp.color <- color;
				set color <- black;
			}
		}
	}
}


experiment schelling type: gui {
	output {
		display Segregation {
			grid space;
		}

		display Charts {
			chart name: "Proportion of happiness" type: pie background: #lightgray style: exploded position: { 0, 0 } size: { 1.0, 0.5 } {
				data "Unhappy" value: number_of_people - sum_happy_people color: #green;
				data "Happy" value: sum_happy_people color: #yellow;
			}

			chart name: "Global happiness and similarity" type: series background: #lightgray axes: #white position: { 0, 0.5 } size: { 1.0, 0.5 }  x_range: 50{
				data "happy" color: #blue value: (sum_happy_people / number_of_people) * 100 style: spline;
				data "similarity" color: #red value: (sum_similar_neighbours / sum_total_neighbours) * 100 style: step;
			}

		}

	}

}
```