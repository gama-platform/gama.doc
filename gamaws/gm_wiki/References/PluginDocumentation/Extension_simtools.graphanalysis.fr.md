# Extension ## {#extension}

----

 simtools.graphanalysis.fr

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}


### Statements ## {#statements}
[layout_forceatlas2](references#layout_forceatlas2), [layout_yifanhu](references#layout_yifanhu), 

### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}



----

## Operators ## {#operators}
	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
	

----
[//]: # (keyword|statement_layout_forceatlas2)
<div class='gama-keyword-style' id ='408_0_1631_statement-layout-forceatlas2'></div>
### layout_forceatlas2  ## {#layout-forceatlas2}
#### Facets  ## {#facets}
  
  * **`graph`** (graph), (omissible) : the graph to apply the layout.
  * `approximate_repulsion` (boolean): Barnes Hut optimization: n2 complexity to n.ln(n); allows larger graphs. default: false
  * `approximation` (float): Theta of the Barnes Hut optimization. default: 1.2
  * `bounded_point1` (point): The new nodes positions are bounded within the two bound points if both are not null. default: null
  * `bounded_point2` (point): The new nodes positions are bounded within the two bound points if both are not null. default: null
  * `dissuade_hubs` (boolean): Distributes attraction along outbound edges. Hubs attract less and thus are pushed to the borders (default: false).
  * `edge_weight_influence` (float): How much influence you give to the edges wight. 0 is no influence, 1 is normal. default: 1.0
  * `gravity` (float): Attracts nodes to the center. Prevents islands from drifting away. default: 1.0
  * `linlog_mode` (boolean): Switch model from lin-lin to lin-log. Makes clusters more tight (default: false).
  * `nb_steps` (int): The number of steps of the algorithm to perform (default 1).
  * `prevent_overlap` (boolean): Should not be used with approximate_repulsion default: false
  * `scaling` (float): How much repulsion you want. More makes a more sparse graph. default: 2.0
  * `stronger_gravity` (boolean): A stronger gravity law default: false
  * `thread_number` (int): More threads means more speed (default: 1).
  * `tolerance` (float): How much swinging you allow. Above 1 discouraged. Lower gives less speed and more precision. default: 0.1

#### Embedments ## {#embedments}
* The `layout_forceatlas2` statement is of type: **Single statement**
* The `layout_forceatlas2` statement can be embedded into: Behavior, Sequence of statements or action, 
* The `layout_forceatlas2` statement embeds statements: 

[Top of the page](references#table-of-contents)
		
	

----
[//]: # (keyword|statement_layout_yifanhu)
<div class='gama-keyword-style' id ='408_1_1632_statement-layout-yifanhu'></div>
### layout_yifanhu  ## {#layout-yifanhu}
#### Facets  ## {#facets}
  
  * **`graph`** (graph), (omissible) : the graph to apply the layout.
  * `bounded_point1` (point): The new nodes positions are bounded within the two bound points if both are not null. default: null
  * `bounded_point2` (point): The new nodes positions are bounded within the two bound points if both are not null. default: null
  * `nb_steps` (int): The number of steps of the algorithm to perform (default 1).
  * `optimal_distance` (float): the natural length of the springs. Bigger values mean nodes will be farther apart (default: 100).
  * `quadtree_max_level` (int): The maximum level to be used in the quadtree representation. Greater values mean more accuracy (default: 10).
  * `relative_strength` (float): The relative strength between electrical force (repulsion) and spring force (attriaction). default: 0.2
  * `step_size` (float): The step size used in the algorithm. It has to be a meaningful size compared to the optimal distance (e.g. 10%). default: 10
  * `theta` (float): The theta parameter for Barnes-Hut opening criteria. Smaller values mean more accuracy (default: 1.2).

#### Embedments ## {#embedments}
* The `layout_yifanhu` statement is of type: **Single statement**
* The `layout_yifanhu` statement can be embedded into: Behavior, Sequence of statements or action, 
* The `layout_yifanhu` statement embeds statements: 

[Top of the page](references#table-of-contents)
		
		
	
----

## Species ## {#species}
	
	
----

## Architectures  ## {#architectures}
	