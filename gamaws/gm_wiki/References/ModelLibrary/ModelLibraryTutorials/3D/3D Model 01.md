# Basic model ## {#basic-model}


_Author : Arnaud Grignard_

First part of the tutorial : Tuto3D


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 01\View1-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 01\View1-10.png){.img-responsive}

Code of the model : 

```

model Tuto3D

global {
  int nb_cells <-100;	
  init { 
    create cells number: nb_cells { 
      location <- {rnd(100), rnd(100), rnd(100)};       
    } 
  }  
} 
  
species cells{                      
  aspect default {
    draw sphere(1) color:#blue;   
  }
}

experiment Tuto3D  type: gui {
  parameter "Initial number of cells: " var: nb_cells min: 1 max: 1000 category: "Cells" ;	
  output {
    display View1 type:opengl {
      species cells;
    }
  }
}
```