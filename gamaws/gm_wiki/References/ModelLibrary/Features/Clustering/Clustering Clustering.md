[//]: # (keyword|operator_dbscan)
<div class='gama-keyword-style' id ='145_0_253_operator-dbscan'></div>
[//]: # (keyword|operator_rnd_color)
<div class='gama-keyword-style' id ='145_1_459_operator-rnd-color'></div>
[//]: # (keyword|operator_kmeans)
<div class='gama-keyword-style' id ='145_2_367_operator-kmeans'></div>
[//]: # (keyword|concept_clustering)
<div class='gama-keyword-style' id ='145_3_18_concept-clustering'></div>
[//]: # (keyword|concept_statistic)
<div class='gama-keyword-style' id ='145_4_108_concept-statistic'></div>
#  Clustering of agents by K Means and DBScan ## {#clustering-of-agents-by-k-means-and-dbscan}


_Author :  Patrick Taillandier_

A model to show how to use clustering operators and two methods of clustering (K Means and DBScan) with the goal of regrouping agents in clusters


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Clustering\Clustering Clustering\map_dbscan-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Clustering\Clustering Clustering\map_dbscan-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Clustering\Clustering Clustering\map_kmeans-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Clustering\Clustering Clustering\map_kmeans-10.png){.img-responsive}

Code of the model : 

```

model clustering

global {
	//the number of groups to create (kmeans)
	int k <- 4;
	
	//the maximum radius of the neighborhood (DBscan)
	float eps <- 10.0; 
	
	//the minimum number of elements needed for a cluster (DBscan)
	int minPoints <- 3;
	
	init {
		//create dummy agents
		create dummy number: 100;
	}
	
	reflex cluster_building {
		//create a list of list containing for each dummy agent a list composed of its x and y values
		list<list> instances <- dummy collect ([each.location.x, each.location.y]);
		
		//from the previous list, create groups with the eps and minPoints parameters and the DBSCAN algorithm (https://en.wikipedia.org/wiki/DBSCAN)
		list<list<int>> clusters_dbscan <- list<list<int>>(dbscan(instances, eps,minPoints));
		
		//We give a random color to each group (i.e. to each dummy agents of the group)
       loop cluster over: clusters_dbscan {
			rgb col <- rnd_color(255);
			loop i over: cluster {
				ask dummy[i] {color_dbscan <- col;}
			}
		}
		
		//from the previous list, create k groups  with the Kmeans algorithm (https://en.wikipedia.org/wiki/K-means_clustering)
		list<list<int>> clusters_kmeans <- list<list<int>>(kmeans(instances, k));
		
		//We give a random color to each group (i.e. to each dummy agents of the group)
		loop cluster over: clusters_kmeans {
			rgb col <- rnd_color(255);
			loop i over: cluster {
				ask dummy[i] {color_kmeans <- col;}
			}
		}
	}
	
}

species dummy {
	rgb color_dbscan <- #white;
	rgb color_kmeans <- #white;
	aspect dbscan_aspect {
		draw circle(2) color: color_dbscan;
	}
	aspect kmeans_aspect {
		draw circle(2) color: color_kmeans;
	}
}

experiment clustering type: gui {
	parameter "Number of clusters to split the data into" var: k category: "KMEANS";
	parameter "Maximum radius of the neighborhood to be considered" var: eps category: "DBSCAN";
	parameter "Minimum number of points needed for a cluster " var: minPoints category: "DBSCAN";
	output {
		display map_dbscan{
			species dummy aspect: dbscan_aspect;
		}
		display map_kmeans{
			species dummy aspect: kmeans_aspect;
		}
	}
}
```