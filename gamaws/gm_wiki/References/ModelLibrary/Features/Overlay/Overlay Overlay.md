[//]: # (keyword|operator_font)
<div class='gama-keyword-style' id ='219_0_295_operator-font'></div>
[//]: # (keyword|statement_overlay)
<div class='gama-keyword-style' id ='219_1_609_statement-overlay'></div>
[//]: # (keyword|constant_#pixels)
<div class='gama-keyword-style' id ='219_2_1317_constant--pixels'></div>
[//]: # (keyword|constant_#bold)
<div class='gama-keyword-style' id ='219_3_1177_constant--bold'></div>
[//]: # (keyword|concept_overlay)
<div class='gama-keyword-style' id ='219_4_1610_concept-overlay'></div>
[//]: # (keyword|concept_display)
<div class='gama-keyword-style' id ='219_5_33_concept-display'></div>
[//]: # (keyword|concept_graphic)
<div class='gama-keyword-style' id ='219_6_49_concept-graphic'></div>
# Overlay ## {#overlay}


_Author : Alexis Drogoul and Patrick Taillandier_

Model to show how to use overlay layers in a display


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Overlay\Overlay Overlay\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Overlay\Overlay Overlay\map-10.png){.img-responsive}

Code of the model : 

```

model Overlay

global
{
	//define the color for each possible type (among "water", "vegetation" and "building")
	map<string,rgb> color_per_type <- ["water"::#blue, "vegetation":: #green, "building":: #pink];
}

//define a simple grid with 10 rows and 10 columns
grid cell width: 10 height: 10 {
	//each cell has a random type
	string type <- one_of(color_per_type.keys);
	rgb color <- color_per_type[type];
}
experiment overlay type: gui
{
    output 
    {
        display map 
        {
        	//define a new overlay layer positioned at the coordinate 5,5, with a constant size of 180 pixels per 100 pixels.
            overlay position: { 5, 5 } size: { 180 #px, 100 #px } background: # black transparency: 0.5 border: #black rounded: true
            {
            	//for each possible type, we draw a square with the corresponding color and we write the name of the type
                float y <- 30#px;
                loop type over: color_per_type.keys
                {
                    draw square(10#px) at: { 20#px, y } color: color_per_type[type] border: #white;
                    draw type at: { 40#px, y + 4#px } color: # white font: font("SansSerif", 18, #bold);
                    y <- y + 25#px;
                }

            }
            //then we display the grid
			grid cell lines: #black;
        }

    }
}
```