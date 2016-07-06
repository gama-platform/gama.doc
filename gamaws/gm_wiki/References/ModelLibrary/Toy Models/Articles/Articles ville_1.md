[//]: # (keyword|operator_gauss)
<div class='gama-keyword-style' id ='296_0_301_operator-gauss'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='296_1_52_concept-gui'></div>
# Ville 1 ## {#ville-1}


_Author : _

This is a simple model showing different circle with a color according to the income of the house.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_1\carte_principale-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Articles\Articles ville_1\carte_principale-10.png){.img-responsive}

Code of the model : 

```
model ville

global {
	init {
		create foyer number: 500;
	}
}

species batiment {
	string type;
	int capacite;
}

species route {
}

species foyer {
	float revenu <- gauss(1500, 500);
	bool est_satisfait ;
	batiment habitation;
	batiment lieu_travail;
	
	aspect revenu {
		int val <- int(255 * (revenu / 3000));
		draw circle(5) color: rgb(255 - val, val, 0);
	}
}

experiment ville type: gui { 
	output {
		display carte_principale {
			species foyer aspect: revenu;
		}
	}
}
```