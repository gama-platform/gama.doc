# Extension ## {#extension}

----

 idees.gama.weka

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}
[clustering_cobweb](references#clustering_cobweb), [clustering_DBScan](references#clustering_dbscan), [clustering_em](references#clustering_em), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_xmeans](references#clustering_xmeans), 

### Statements ## {#statements}


### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}



----

## Operators ## {#operators}
	
    	
----
[//]: # (keyword|operator_clustering_cobweb)
<div class='gama-keyword-style' id ='402_0_1621_operator-clustering-cobweb'></div>
### `clustering_cobweb` ## {#clustering-cobweb}

#### Possible use:  ## {#possible-use}
  *  **`clustering_cobweb`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clusteredby CobWeb Algorithm based on the given attributes. Some paremeters can be defined: acuity: minimum standard deviation for numeric attributes; cutoff: category utility threshold by which to prune nodes seed

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_cobweb([ag1, ag2, ag3, ag4, ag5],["size","age", "weight"],["acuity"::3.0, "cutoff"::0.5); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_xmeans](references#clustering_xmeans), [clustering_em](references#clustering_em), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_clustering_DBScan)
<div class='gama-keyword-style' id ='402_1_1622_operator-clustering-DBScan'></div>
### `clustering_DBScan` ## {#clustering-dbscan}

#### Possible use:  ## {#possible-use}
  *  **`clustering_DBScan`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clustered by DBScan Algorithm based on the given attributes. Some paremeters can be defined: distance_f: The distance function to use for instances comparison (euclidean or manhattan); min_points: minimun number of DataObjects required in an epsilon-range-queryepsilon: epsilon -- radius of the epsilon-range-queries

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_DBScan([ag1, ag2, ag3, ag4, ag5],["size","age", "weight"],["distance_f"::"manhattan"]); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_xmeans](references#clustering_xmeans), [clustering_em](references#clustering_em), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_clustering_em)
<div class='gama-keyword-style' id ='402_2_1623_operator-clustering-em'></div>
### `clustering_em` ## {#clustering-em}

#### Possible use:  ## {#possible-use}
  *  **`clustering_em`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clustered by EM Algorithm based on the given attributes. Some paremeters can be defined: max_iterations: the maximum number of iterations to perform;num_clusters: the number of clusters; minStdDev: minimum allowable standard deviation

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_em([ag1, ag2, ag3, ag4, ag5],["size","age", "weight"],["max_iterations"::10, "num_clusters"::3]); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_xmeans](references#clustering_xmeans), [clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_DBScan](references#clustering_dbscan), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_clustering_farthestFirst)
<div class='gama-keyword-style' id ='402_3_1624_operator-clustering-farthestFirst'></div>
### `clustering_farthestFirst` ## {#clustering-farthestfirst}

#### Possible use:  ## {#possible-use}
  *  **`clustering_farthestFirst`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clustered by Farthest First Algorithm based on the given attributes. Some paremeters can be defined: num_clusters: the number of clusters

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_farthestFirst([ag1, ag2, ag3, ag4, ag5],["size","age", "weight"],["num_clusters"::3]); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_xmeans](references#clustering_xmeans), [clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_em](references#clustering_em), [clustering_DBScan](references#clustering_dbscan), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_clustering_simple_kmeans)
<div class='gama-keyword-style' id ='402_4_1625_operator-clustering-simple-kmeans'></div>
### `clustering_simple_kmeans` ## {#clustering-simple-kmeans}

#### Possible use:  ## {#possible-use}
  *  **`clustering_simple_kmeans`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clustered by K-Means Algorithm based on the given attributes. Some paremeters can be defined: distance_f: The distance function to use. 4 possible distance functions: euclidean (by default) ; 'chebyshev', 'manhattan' or 'levenshtein'; dont_replace_missing_values: if false, replace missing values globally with mean/mode; max_iterations: the maximum number of iterations to perform;num_clusters: the number of clusters

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_simple_kmeans([ag1, ag2, ag3, ag4, ag5],["size","age", "weight"],["distance_f"::"manhattan", "num_clusters"::3]); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_xmeans](references#clustering_xmeans), [clustering_em](references#clustering_em), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_DBScan](references#clustering_dbscan), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_clustering_xmeans)
<div class='gama-keyword-style' id ='402_5_1626_operator-clustering-xmeans'></div>
### `clustering_xmeans` ## {#clustering-xmeans}

#### Possible use:  ## {#possible-use}
  *  **`clustering_xmeans`** (`list<agent>`, `msi.gama.util.IList<java.lang.String>`, `map<string,unknown>`) --->  `list<list<agent>>` 

#### Result:  ## {#result}
A list of agent groups clustered by X-Means Algorithm based on the given attributes. Some paremeters can be defined: bin_value: value given for true value of boolean attributes; cut_off_factor: the cut-off factor to use;distance_f: The distance function to use. 4 possible distance functions: euclidean (by default) ; 'chebyshev', 'manhattan' or 'levenshtein'; max_iterations: the maximum number of iterations to perform; max_kmeans: the maximum number of iterations to perform in KMeans; max_kmeans_for_children: the maximum number of iterations KMeans that is performed on the child centers;max_num_clusters: the maximum number of clusters; min_num_clusters: the minimal number of clusters

#### Examples:  ## {#examples}
```
list<list<agent>> var0 <- clustering_xmeans([ag1, ag2, ag3, ag4, ag5],["size","age", "weight", "is_male"],["bin_value"::1.0, "distance_f"::"manhattan", "max_num_clusters"::10, "min_num_clusters"::2]); 	// var0 equals for example, can return [[ag1, ag3], [ag2], [ag4, ag5]]
```
      

#### See also:  ## {#see-also}
[clustering_simple_kmeans](references#clustering_simple_kmeans), [clustering_em](references#clustering_em), [clustering_farthestFirst](references#clustering_farthestfirst), [clustering_DBScan](references#clustering_dbscan), [clustering_cobweb](references#clustering_cobweb), 

[Top of the page](references#table-of-contents)
  	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
		
	
----

## Species ## {#species}
	
	
----

## Architectures  ## {#architectures}
	