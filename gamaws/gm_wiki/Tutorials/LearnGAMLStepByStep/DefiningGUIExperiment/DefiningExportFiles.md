[//]: # (startConcept|export_files)
<section class='concept-graph' markdown='1' id ='concept_32_0_37_export-files'>
[//]: # (keyword|concept_file)
<div class='gama-keyword-style' id ='32_0_41_concept-file'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='32_1_65_concept-load-file'></div>
# Defining export files ## {#defining-export-files}

## Index ## {#index}

* [The Save Statement](tutorials#the-save-statement)
* [Export files in experiment](tutorials#export-files-in-experiment)
* [Autosave](tutorials#autosave)

## The Save Statement ## {#the-save-statement}

[//]: # (keyword|statement_save)
<div class='gama-keyword-style' id ='32_2_622_statement-save'></div>
Allows to save data in a file. The type of file can be "shp", "text" or "csv". The **`save`** statement can be use in an init block, a reflex, an action or in a user command. Do not use it in experiments.

### Facets  ## {#facets}

  * **`to`** (string): an expression that evaluates to an string, the path to the file
  * `data` (any type), (omissible) : any expression, that will be saved in the file
  * `crs` (any type): the name of the projectsion, e.g. crs:"EPSG:4326" or its EPSG id, e.g. crs:4326. Here a list of the CRS codes (and EPSG id): http://spatialreference.org
  * `rewrite` (boolean): an expression that evaluates to a boolean, specifying whether the save will ecrase the file or append data at the end of it
  * `type` (an identifier): an expression that evaluates to an string, the type of the output file (it can be only "shp", "text" or "csv")
  * `with` (map):  

### Usages ## {#usages}

* Its simple syntax is:

```
save data to: output_file type: a_type_file;
```

[//]: # (keyword|concept_text)
<div class='gama-keyword-style' id ='32_3_116_concept-text'></div>
* To save data in a text file:

```
save (string(cycle) + "->"  + name + ":" + location) to: "save_data.txt" type: "text";
```

[//]: # (keyword|concept_csv)
<div class='gama-keyword-style' id ='32_4_26_concept-csv'></div>
* To save the values of some attributes of the current agent in csv file:

```
save [name, location, host] to: "save_data.csv" type: "csv";
```

[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='32_5_99_concept-shapefile'></div>
* To save the geometries of all the agents of a species into a shapefile (with optional attributes):

```
save species_of(self) to: "save_shapefile.shp" type: "shp" with: [name::"nameAgent", location::"locationAgent"] crs: "EPSG:4326";
```

## Export files in experiment ## {#export-files-in-experiment}

[//]: # (keyword|statement_output_file)
<div class='gama-keyword-style' id ='32_6_608_statement-output-file'></div>
Displays are not the only output you can manage in GAMA. Saving data to a file during an experiment can also be achieved in several ways, depending on the needs of the modeler. One way is provided by the `save` statement, which can be used everywhere in a model or a species. The other way, described here, is to include an **`output_file`** statement in the output section.

```
output_file name:"file_name" type:file_type data:data_to_write; 
```

with:

`file_type`: text, csv or xml
`file_name`: string
`data_to_write`: string

### Example: ## {#example}

```
file name: "results" type: text data: time + "; " + nb_preys + ";" + nb_predators refresh:every(2);  
```

Each time step (or according to the frequency defined in the `refresh` facet of the file output), a new line will be added at the end of the file. If `rewrite: false` is defined in its facets, a new file will be created for each simulation (identified by a timestamp in its name).

Optionally, a `footer` and a `header` can also be described with the corresponding facets (of type string).

## Autosave ## {#autosave}

[//]: # (keyword|concept_autosave)
<div class='gama-keyword-style' id ='32_7_10_concept-autosave'></div>
Image files can be exported also through the `autosave` facet of the display, as explained in [this previous part](tutorials#DefiningDisplaysGeneralities#displays-and-layers){.internal-link-anchor}.
[//]: # (endConcept|export_files)
</section>