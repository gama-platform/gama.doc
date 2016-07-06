[//]: # (keyword|operator_rotated_by)
<div class='gama-keyword-style' id ='133_0_460_operator-rotated-by'></div>
[//]: # (keyword|operator_box)
<div class='gama-keyword-style' id ='133_1_211_operator-box'></div>
[//]: # (keyword|operator_sin)
<div class='gama-keyword-style' id ='133_2_482_operator-sin'></div>
[//]: # (keyword|operator_cos)
<div class='gama-keyword-style' id ='133_3_241_operator-cos'></div>
[//]: # (keyword|operator_hsb)
<div class='gama-keyword-style' id ='133_4_324_operator-hsb'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='133_5_1_concept-3d'></div>
[//]: # (keyword|concept_texture)
<div class='gama-keyword-style' id ='133_6_117_concept-texture'></div>
[//]: # (keyword|concept_light)
<div class='gama-keyword-style' id ='133_7_63_concept-light'></div>
# Procedural City ## {#procedural-city}


_Author : Arnaud Grignard_

Model with a 3D Display representing buildings with a random size. The model proposes two experiments : the first one represents the buildings with 3D shapes with textures, the second one without textures but the color of the buildings depends on the rotation of a ball-shaped light


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization Procedural City\City-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization Procedural City\City-10.png){.img-responsive}

Code of the model : 

```

model procedural_city   

global {
	int number_of_building parameter: 'Number of Agents' min: 1 <- 300 category: 'Initialization';
	int width_and_height_of_environment parameter: 'Dimensions' min: 10 <- 500 category: 'Initialization';
	
	geometry shape <- square(width_and_height_of_environment);
		
	file roof_texture <- file('../images/building_texture/roof_top.png') ;		
	list textures <- [file('../images/building_texture/texture1.jpg'),file('../images/building_texture/texture2.jpg'),file('../images/building_texture/texture3.jpg'),file('../images/building_texture/texture4.jpg'),file('../images/building_texture/texture5.jpg'),
	file('../images/building_texture/texture6.jpg'),file('../images/building_texture/texture7.jpg'),file('../images/building_texture/texture8.jpg'),file('../images/building_texture/texture9.jpg'),file('../images/building_texture/texture10.jpg')];

	init { 
      create Building number:number_of_building{
      	     width <- (rnd(100)/100)*(rnd(100)/100)*(rnd(100)/100)*50+10;
			 depth <-	(rnd(100)/100)*(rnd(100)/100)*(rnd(100)/100*width)*10+10;
			shape <- box(width, width, depth) rotated_by rnd(360);
			texture <- textures[rnd(9)];
		}
	}  

} 

species Building{
	float width;
	float height;
	float depth;
	int angle;			
	file texture;
	
	reflex shuffle{
		 width <- (rnd(100)/100)*(rnd(100)/100)*(rnd(100)/100)*50+10;
		 depth <-	(rnd(100)/100)*(rnd(100)/100)*(rnd(100)/100*width)*10+10;
		shape <- box(width, width, depth) rotated_by rnd(360);
	}
	
	aspect base {
		draw shape;
	}
	
	aspect textured {
		draw shape texture:[roof_texture.path,texture.path] ;
	}
}	


experiment DisplayTextured  type: gui {
	output {
	  display City type:opengl background:rgb(10,40,55){
			species Building aspect:textured;							
		}
	}
}
experiment DisplayWithDynamicDiffuseLight  type: gui {
	output {
	  display City type:opengl draw_diffuse_light:true diffuse_light:hsb((time mod 255) /255,1.0 ,0.5)  diffuse_light_pos:{world.shape.width*0.5+ world.shape.width*1.5*sin(time*2),world.shape.width*0.5,world.shape.width*cos(time*2)} background:rgb(10,40,55){
			species Building aspect:base;									
		}
	}
}

```