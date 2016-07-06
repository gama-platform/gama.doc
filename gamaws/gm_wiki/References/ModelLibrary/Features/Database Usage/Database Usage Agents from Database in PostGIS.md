[//]: # (keyword|skill_SQLSKILL)
<div class='gama-keyword-style' id ='174_0_1165_skill-SQLSKILL'></div>
[//]: # (keyword|concept_database)
<div class='gama-keyword-style' id ='174_1_28_concept-database'></div>
#  Agents from Database in PostGIS ## {#agents-from-database-in-postgis}


_Author : Benoit Gaudou_

 This model does SQL query commands and create agents using the results


Code of the model : 

```
model DB2agentMySQL 

global {
	map<string,string> BOUNDS <- [	//'srid'::'32648', // optinal
	 								'host'::'localhost',
									'dbtype'::'postgres',
									'database'::'spatial_DB',
									'port'::'5433',
									'user'::'postgres',
									'passwd'::'tmt',
								  	'select'::'SELECT ST_AsBinary(geom) as geom FROM buildings;' ];
	map<string,string> PARAMS <- [	//'srid'::'32648', // optinal
									'host'::'localhost',
									'dbtype'::'postgres',
									'database'::'spatial_DB',
									'port'::'5433',
									'user'::'postgres',
									'passwd'::'tmt'];
	
	string QUERY <- "SELECT name, type, ST_AsBinary(geom) as geom FROM buildings ;";
	geometry shape <- envelope(BOUNDS);		  	
		  	
	init {
		create DB_accessor {
			create buildings from: (self select [params:: PARAMS, select:: QUERY]) 
							 with:[ 'name'::"name",'type'::"type", 'shape':: geometry("geom")];
		 }
	}
}

species DB_accessor skills: [SQLSKILL];

species buildings {
	string type;
	aspect default {
		draw shape color: #gray ;
	}	
}	

experiment DB2agentSQLite type: gui {
	output {
		display fullView {
			species buildings aspect: default;
		}
	}
}
```