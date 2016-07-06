[//]: # (startConcept|use_osm_datas)
<section class='concept-graph' markdown='1' id ='concept_44_0_38_use-osm-datas'>
[//]: # (keyword|concept_osm)
<div class='gama-keyword-style' id ='44_0_82_concept-osm'></div>
# Manipulate OSM Datas ## {#manipulate-osm-datas}

[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='44_1_65_concept-load-file'></div>
This section will be presented as a quick tutorial, showing how to proceed to manipulate OSM (Open street map) datas, and load them into GAMA. We will use the software [QGIS](http://www.qgis.org/en/site/) to change the attributes of the OSM file.


From the website [openstreetmap.org](https://www.openstreetmap.org/), we will chose a place (in this example, we will take a neighborhood in New York City). Directly from the website, you can export the chosen area in the osm format.

![images/manipulate_OSM_file_1.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_1.png){.img-responsive}

We have now to manipulate the attributes for the exported osm file.
Several software are possible to use, but we will focus on [QGIS](http://www.qgis.org/en/site/), which is totally free and provides a lot of possibilities in term of manipulation of data.

Once you have installed correctly QGIS, launch QGIS Desktop, and start to import the topology from the osm file.

![images/manipulate_OSM_file_2.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_2.png){.img-responsive}

![images/manipulate_OSM_file_3.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_3.png){.img-responsive}

A message indicates that the import was successful. An output file .osm.db is created. You have now to export the topology to SpatiaLite.

![images/manipulate_OSM_file_4.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_4.png){.img-responsive}

Specify the path for your DataBase file, then choose the export type (in your case, we will choose the type "Polygons (closed ways)"), choose an output layer name. If you want to use the open street maps attributes values, click on "Load from DB", and select the attributes you want to keep. Click OK then.

![images/manipulate_OSM_file_5.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_5.png){.img-responsive}

A message indicates that the export was successful, and you have now a new layer created.

![images/manipulate_OSM_file_6.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_6.png){.img-responsive}

We will now manipulate the attributes of your datafile. Right click on the layer, and select "Open Attribute Table".

![images/manipulate_OSM_file_7.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_7.png){.img-responsive}

The table of attribute appears. Select the little pencil on the top-left corner of the window to modify the table.

![images/manipulate_OSM_file_8.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_8.png){.img-responsive}

We will add an attribute manually. Click on the button "new column", choose a name and a type (we will choose the type "text").

![images/manipulate_OSM_file_9.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_9.png){.img-responsive}

A new column appears at the end of the table. Let's fill some values (for instance blue / red). Once you finishes, click on the "save edit" button.

![images/manipulate_OSM_file_10.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_10.png){.img-responsive}

Our file is now ready to be exported. Right click on the layer, and click on "Save As".

![images/manipulate_OSM_file_11.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_11.png){.img-responsive}

Choose "shapefile" as format, choose a save path and click ok.

![images/manipulate_OSM_file_12.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_12.png){.img-responsive}

Copy passed all the .shp created in the include folder of your GAMA project. You are now ready to write the model.

[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='44_2_99_concept-shapefile'></div>
```
model HowToUseOpenStreetMap

global {
	// Global variables related to the Management units	
	file shapeFile <- file('../includes/new_york.shp'); 
	
	//definition of the environment size from the shapefile. 
	//Note that is possible to define it from several files by using: geometry shape <- envelope(envelope(file1) + envelope(file2) + ...);
	geometry shape <- envelope(shapeFile);
	
	init {
		//Creation of elementOfNewYork agents from the shapefile (and reading some of the shapefile attributes)
		create elementOfNewYork from: shapeFile 
			with: [elementId::int(read('id')), elementHeight::int(read('height')), elementColor::string(read('attrForGama'))] ;
    }
}
	
species elementOfNewYork{
	int elementId;
	int elementHeight;
	string elementColor;
	
	aspect basic{
		draw shape color: (elementColor = "blue") ? #blue : ( (elementColor = "red") ? #red : #yellow ) depth: elementHeight;
	}
}	

experiment main type: gui {		
	output {
		display HowToUseOpenStreetMap type:opengl {
	   		species elementOfNewYork aspect: basic; 
		}
	}
}
```

Here is the result, with a special colorization of the different elements regarding to the value of the attribute "attrForGama", and an elevation regarding to the value of the attribute "height".

![images/manipulate_OSM_file_13.png](gm_wiki/resources/images/recipes/manipulate_OSM_file_13.png){.img-responsive}
[//]: # (endConcept|use_osm_datas)
</section>