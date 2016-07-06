# Extension ## {#extension}

----

 simtools.gamanalyzer.fr

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}


### Statements ## {#statements}
[analyse](references#analyse), 

### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}
[agent_group_follower](references#agent_group_follower), [AgGroupAnalizer](references#aggroupanalizer), [cluster_builder](references#cluster_builder), 


----

## Operators ## {#operators}
	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
	

----
[//]: # (keyword|statement_analyse)
<div class='gama-keyword-style' id ='407_0_1627_statement-analyse'></div>
### analyse  ## {#analyse}
#### Facets  ## {#facets}
  
  * **`species_to_analyse`** (any type in [string, string]), (omissible) :   
  * **`with_constraint`** (any type in [string, string]): 

#### Embedments ## {#embedments}
* The `analyse` statement is of type: **Single statement**
* The `analyse` statement can be embedded into: experiment, 
* The `analyse` statement embeds statements: 

[Top of the page](references#table-of-contents)
		
		
	
----

## Species ## {#species}
	
    	
----
[//]: # (keyword|species_agent_group_follower)
<div class='gama-keyword-style' id ='407_1_1628_species-agent-group-follower'></div>
## `agent_group_follower`	 ## {#agent-group-follower}

### Actions ## {#actions}
	  
	 
#### **`analyse_cluster`** ## {#analyse-cluster}

* returns: `void`
 			
* → **`species_to_analyse`** (`string`):   
	 
#### **`at_cycle`** ## {#at-cycle}

* returns: `list`
 			
* → **`with_matrix`** (`string`):  			
* → **`with_var`** (`string`):   
	 
#### **`at_var`** ## {#at-var}

* returns: `list`
 			
* → **`with_matrix`** (`string`):  			
* → **`with_var`** (`string`):   
	 
#### **`distrib_legend`** ## {#distrib-legend}

* returns: `list`
 			
* → **`with_var`** (`string`): 			

[Top of the page](references#table-of-contents) 
	
    	
----
[//]: # (keyword|species_AgGroupAnalizer)
<div class='gama-keyword-style' id ='407_2_1629_species-AgGroupAnalizer'></div>
## `AgGroupAnalizer`	 ## {#aggroupanalizer}

### Actions ## {#actions}
	  
	 
#### **`creation_cluster`** ## {#creation-cluster}

* returns: `void`
			

[Top of the page](references#table-of-contents) 
	
    	
----
[//]: # (keyword|species_cluster_builder)
<div class='gama-keyword-style' id ='407_3_1630_species-cluster-builder'></div>
## `cluster_builder`	 ## {#cluster-builder}

### Actions ## {#actions}
	  
	 
#### **`clustering_cobweb`** ## {#clustering-cobweb}

* returns: `list<list<agent>>`
  
	 
#### **`clustering_DBScan`** ## {#clustering-dbscan}

* returns: `list<list<agent>>`
  
	 
#### **`clustering_em`** ## {#clustering-em}

* returns: `list<list<agent>>`
  
	 
#### **`clustering_farthestFirst`** ## {#clustering-farthestfirst}

* returns: `list<list<agent>>`
  
	 
#### **`clustering_simple_kmeans`** ## {#clustering-simple-kmeans}

* returns: `list<list<agent>>`
 			
* → **`agents`** (`list`):  			
* → **`attributes`** (`list`):  			
* → **`distance_f`** (``):  			
* → **`dont_replace_missing_values`** (``):  			
* → **`max_iterations`** (``):  			
* → **`num_clusters`** (``):  			
* → **`preserve_instances_order`** (``):  			
* → **`seed`** (``):   
	 
#### **`clustering_xmeans`** ## {#clustering-xmeans}

* returns: `list<list<agent>>`
 			
* → **`agents`** (`list`):  			
* → **`attributes`** (`list`):  			
* → **`bin_value`** (`float`): value that represents true in the new attributes 			
* → **`cut_off_factor`** (`float`): the cut-off factor to use 			
* → **`distance_f`** (`string`): The distance function to use. 4 possible distance functions: euclidean (by default) ; 'chebyshev', 'manhattan' or 'levenshtein' 			
* → **`max_iterations`** (`int`): the maximum number of iterations to perform 			
* → **`max_kmeans`** (`int`): the maximum number of iterations to perform in KMeans 			
* → **`max_kmeans_for_children`** (`int`): the maximum number of iterations KMeans that is performed on the child centers 			
* → **`max_num_clusters`** (`int`): the maximum number of clusters 			
* → **`min_num_clusters`** (`int`): the maximum number of clusters 			
* → **`seed`** (`int`): random number seed to be used			

[Top of the page](references#table-of-contents) 
	
	
----

## Architectures  ## {#architectures}
	