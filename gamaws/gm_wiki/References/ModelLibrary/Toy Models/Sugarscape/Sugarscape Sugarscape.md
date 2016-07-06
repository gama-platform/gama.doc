[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='347_0_614_statement-put'></div>
[//]: # (keyword|constant_#lightgray)
<div class='gama-keyword-style' id ='347_1_1256_constant--lightgray'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='347_2_51_concept-grid'></div>
# sugarscape ## {#sugarscape}


_Author : _

A model with animal moving on a grid to find sugar. The animal agents have a life duration and die if it is reached or if they don't have anymore sugar.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\chart-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\chart-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\chart2-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\chart2-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\grille-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Sugarscape\Sugarscape Sugarscape\grille-10.png){.img-responsive}

Code of the model : 

```
model sugarscape

  
global {
	// Parameters 
	
	//Growth rate of the sugar
	int sugarGrowthRate <- 1;
	//Minimum age of death
	int minDeathAge <- 60;
	//Maximum age of death
	int maxDeathAge <- 100;
	//Metabolism maximum
	int maxMetabolism <- 3;
	
	//Maximum and Minimum initial sugar
	int maxInitialSugar <- 25 ;
	int minInitialSugar <- 5;
	//Maximum range
	int maxRange <- 6;
	bool replace <- true;
	//Number of agents
	int numberOfAgents <- 400;	
	
	// Environment
	geometry shape <- rectangle(50, 50);
		
	const types type: file<int> <- file<int>('../images/sugarscape.pgm');
	const red type: rgb <- #red;
	const white type: rgb <- #white;
	const FFFFAA type: rgb <- rgb('#FFFFAA');
	const FFFF55 type: rgb <- rgb('#FFFF55');
	const yellow type: rgb <- #yellow;
	const dark_yellow type: rgb <- rgb('#EEB422');
	const pink type: rgb <- #pink;
	const less_red type: rgb <- rgb('#FF5F5F');
	
	init {
		
		//Create the animal
		create animal number: numberOfAgents;
		
		//Ask to each sugar cell to set its sugar
		ask sugar_cell {
			maxSugar <- (types at {grid_x,grid_y});
			sugar <- maxSugar;
			color <- [white,FFFFAA,FFFF55,yellow,dark_yellow] at sugar;
		}
	}
}

	//Grid species representing the sugar cells
	grid sugar_cell width: 50 height: 50 neighbors: 4 use_individual_shapes: false use_regular_agents: false{ 
		const multiagent type: bool <- false;
		//Maximum sugar
		int maxSugar;
		//Sugar contained in thecell
		int sugar update: sugar + sugarGrowthRate max: maxSugar;
		rgb color update: [white,FFFFAA,FFFF55,yellow,dark_yellow] at sugar;
		map<int,list<sugar_cell>> neighbours;
		
		//Initialization of the neighbours
		init {
			loop i from: 1 to: maxRange {
				neighbours[i] <- self neighbors_at i; 
			}
		}
	}	
	
//Species animal representing the animal agents
species animal {
	//Color of the animal
	const color type: rgb <- red;
	//Speed of the animal
	const speed type: float <- 1.0;
	//Metabolism of the animal
	const metabolism type: int min: 1 <- rnd(maxMetabolism);
	//Perception range of the animal
	const vision type: int min: 1 <- rnd(maxRange);
	//Maximal age of the animal
	const maxAge type: int min: minDeathAge max: maxDeathAge <- rnd (maxDeathAge - minDeathAge) + minDeathAge;
	//Size of the animal
	const size type: float <- 0.5;
	//Sugar of the animal
	int sugar min: 0 <- (rnd (maxInitialSugar - minInitialSugar)) + minInitialSugar update: sugar - metabolism;
	//Age of the animal
	int age max: maxAge <- 0 update: int(age + step);
	//Place of the animal
	sugar_cell place ; 
	
	//Launched at the initialization of the animal agent
	init {
		//Set the place as one of the sugar cell
		place <- one_of(sugar_cell);
		location <- place.location;
	}
	//Move the agent to another place and collect the sugar of the previous place
	reflex basic_move { 
		sugar <- sugar + place.sugar;
		place.sugar <- 0;
		list<sugar_cell> neighbours <- place.neighbours[vision];
		list<sugar_cell> poss_targets <- (neighbours) where (each.sugar > 0);
		//If no sugar is found in the neighbours cells, move randomly
		place <- empty(poss_targets) ? one_of (neighbours) : one_of (poss_targets);
		location <- place.location;
	}
	//Reflex to kill the animal once it reaches its maximal age or it doesn't have sugar anymore
	reflex end_of_life when: (sugar = 0) or (age = maxAge) {
		if replace {
			create animal ;
		}
		do die;
	}
	aspect default {
		draw circle(0.5) color: red;
	}
}

experiment sugarscape type: gui{
	parameter 'Growth rate of sugar:' var: sugarGrowthRate category: 'Environment';
	parameter 'Minimum age of death:' var: minDeathAge <- 60 category: 'Agents';
	parameter 'Maximum age of death:' var: maxDeathAge <- 100 category: 'Agents';
	parameter 'Maximum metabolism:' var: maxMetabolism <- 3 category: 'Agents';
	parameter 'Maximum initial sugar per cell:'  var: maxInitialSugar <- 25 category: 'Environment';
	parameter 'Minimum initial sugar per cell:' var: minInitialSugar <- 5 category: 'Environment';
	parameter 'Maximum range of vision:' var: maxRange <- 6 category: 'Agents';
	parameter 'Replace dead agents ?' var: replace <- true category: 'Agents';
	parameter 'Number of agents:' var: numberOfAgents <- 400 category: 'Agents';
	
	output {
		display grille {
			grid sugar_cell;
			species animal;
		}
		display chart refresh: every(5) {
			chart name: 'Energy' type: pie background: #lightgray style: exploded {
				data "strong" value: (animal as list) count (each.sugar > 8) color: #green;
				data "weak" value: (animal as list) count (each.sugar < 9) color: #red;
			}
		}
		display chart2 refresh: every(5) {
			chart name: 'Energy' type: histogram background: #lightgray {
				data "strong" value: (animal as list) count (each.sugar > 8)  color: #green;
				data "weak" value: (animal as list) count (each.sugar < 9)  color: #red;
			}
		}
	}
}
```