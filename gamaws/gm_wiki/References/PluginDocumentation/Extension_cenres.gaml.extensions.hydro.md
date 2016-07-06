# Extension ## {#extension}

----

 cenres.gaml.extensions.hydro

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}
[water_area_for](references#water_area_for), [water_level_for](references#water_level_for), [water_polylines_for](references#water_polylines_for), 

### Statements ## {#statements}


### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}



----

## Operators ## {#operators}
	
    	
----
[//]: # (keyword|operator_water_area_for)
<div class='gama-keyword-style' id ='400_0_1614_operator-water-area-for'></div>
### `water_area_for` ## {#water-area-for}

#### Possible use:  ## {#possible-use}
  * `geometry` **`water_area_for`** `float` --->  `float`

#### Special cases:      ## {#special-cases}
  * if the left operand is a polyline and the right operand a float for the water y coordinate, returrns the area of the water (water flow area)

#### Examples:  ## {#examples}
```
waterarea <- my_river_polyline water_area_for my_height_value
```
  

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_water_level_for)
<div class='gama-keyword-style' id ='400_1_1615_operator-water-level-for'></div>
### `water_level_for` ## {#water-level-for}

#### Possible use:  ## {#possible-use}
  * `geometry` **`water_level_for`** `float` --->  `float`

#### Special cases:      ## {#special-cases}
  * if the left operand is a polyline and the right operand a float for the area, returrns the y coordinate of the water (water level)

#### Examples:  ## {#examples}
```
waterlevel <- my_river_polyline water_level_for my_area_value
```
  

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_water_polylines_for)
<div class='gama-keyword-style' id ='400_2_1616_operator-water-polylines-for'></div>
### `water_polylines_for` ## {#water-polylines-for}

#### Possible use:  ## {#possible-use}
  * `geometry` **`water_polylines_for`** `float` --->  `msi.gama.util.IList<msi.gama.util.IList<msi.gama.metamodel.shape.GamaPoint>>`

#### Special cases:      ## {#special-cases}
  * if the left operand is a polyline and the right operand a float for the water y coordinate, returrns the shapes of the river sections (list of list of points)

#### Examples:  ## {#examples}
```
waterarea <- my_river_polyline water_area_for my_height_value
```
  

[Top of the page](references#table-of-contents)
  	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
		
	
----

## Species ## {#species}
	
	
----

## Architectures  ## {#architectures}
	