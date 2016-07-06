[//]: # (keyword|operator_as_matrix)
<div class='gama-keyword-style' id ='231_0_193_operator-as-matrix'></div>
[//]: # (keyword|operator_build)
<div class='gama-keyword-style' id ='231_1_215_operator-build'></div>
[//]: # (keyword|operator_predict)
<div class='gama-keyword-style' id ='231_2_437_operator-predict'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='231_3_614_statement-put'></div>
[//]: # (keyword|type_regression)
<div class='gama-keyword-style' id ='231_4_1562_type-regression'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='231_5_1556_type-matrix'></div>
[//]: # (keyword|concept_regression)
<div class='gama-keyword-style' id ='231_6_94_concept-regression'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='231_7_1_concept-3d'></div>
[//]: # (keyword|concept_statistic)
<div class='gama-keyword-style' id ='231_8_108_concept-statistic'></div>
# Regression ## {#regression}


_Author : Patrick Taillandier_

A model which shows how to use the regression 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Statistics\Statistics Regression\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Statistics\Statistics Regression\map-10.png){.img-responsive}

Code of the model : 

```

model example_regression

global {
	//Regression variable that will store the function
	regression location_fct;
	float x_val <- 50.0;
	float y_val <- 50.0;
	
	float val <- -1.0;
	init {
		loop i from: 0 to: 18{
			if (i != 10) {
				create dummy with:[location::{i * 5 + 2 - rnd(4), i*5 + 2 - rnd(4), i*5 + 2 - rnd(4)}];	
			}
		}
	}
	
	//Reflex to compute the regression
	reflex do_regression {
		matrix<float> instances <- 0.0 as_matrix {3,length(dummy)};
		loop i from: 0 to: length(dummy) -1 {
			dummy ag <- dummy[i];
			instances[1,i] <- ag.location.x;
			instances[2,i] <- ag.location.y;
			instances[0,i] <- ag.location.z;
		}
		//Compute the function of regression
		location_fct  <- build(instances);
		write "learnt function: " + location_fct;
		
		//Predict the value using the function resulting before
		val <-  predict(location_fct, [x_val, y_val]);
		write "value : " + val;
	}
}

species dummy {
	aspect default {
		draw sphere(2) color: #blue;
	}
}

experiment main type: gui {
	parameter "Point to test, x value" var: x_val ;
	parameter "Point to test, y value" var: y_val ;
	output {
		display map type: opengl {
			species dummy;
			graphics "new Point " {
				if (location_fct != nil) {
					draw sphere(2) color: #red at: {x_val,y_val,val};
					
					//Draw the function as a line
					draw line([{100,100,predict(location_fct, [100,100])},{-10,-10,predict(location_fct, [-10,-10])}]) color: #black;
				}
				
			}
		}
	}
}
```