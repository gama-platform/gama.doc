[//]: # (keyword|operator_rgb_to_xyz)
<div class='gama-keyword-style' id ='155_0_455_operator-rgb-to-xyz'></div>
[//]: # (keyword|operator_cube)
<div class='gama-keyword-style' id ='155_1_249_operator-cube'></div>
[//]: # (keyword|concept_color)
<div class='gama-keyword-style' id ='155_2_19_concept-color'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='155_3_1_concept-3d'></div>
# RGB color to XYZ position ## {#rgb-color-to-xyz-position}


_Author :  Arnaud Grignard_

A model to show how to convert rgb values in xyz position using the operator rgb_to_xyz. Each pixel of a given image is used to create a point with its coordinates depending on its color : red value for x coordinate, green value for y coordinate and blue value for the z coordinate.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Color\Color RGB to XYZ\RGB_to_XYZ-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Color\Color RGB to XYZ\RGB_to_XYZ-10.png){.img-responsive}

Code of the model : 

```

model rgbCube

global {
	//import an image
	file imageRaster <- file('images/RGB.jpg');
	
	//list of points  create from the image 
	list<point> p;
	
	//geometry of the world (environment)
	geometry shape <- square(255);
	
	//create the list of points from the image: a point is defined per pixel, its coordinate correspond to the value of the red,green,blue color
	init {
		p <- list<point> (rgb_to_xyz(imageRaster));
	}
}


experiment Display type: gui {
	output {
		display RGB_to_XYZ type: opengl { 
			image imageRaster.path refresh: false;
			graphics "pts" refresh: false{
				loop pt over: p {
					draw cube(1) at: pt color: rgb(pt.x, pt.y, pt.z);
				}
			}
		}
	}

}
```