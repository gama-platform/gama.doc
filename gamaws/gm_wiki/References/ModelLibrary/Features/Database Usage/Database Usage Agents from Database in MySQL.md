[//]: # (keyword|skill_SQLSKILL)
<div class='gama-keyword-style' id ='173_0_1165_skill-SQLSKILL'></div>
[//]: # (keyword|concept_database)
<div class='gama-keyword-style' id ='173_1_28_concept-database'></div>
#  Agents from Database in MySQL ## {#agents-from-database-in-mysql}


_Author : Benoit Gaudou_

 This model does SQl query commands and create agents using the results


Code of the model : 

```
model DB2agentMySQL

global {
	map<string,string> BOUNDS <- [	//'srid'::'32648', // optinal
									'host'::'localhost',
									'dbtype'::'MySQL',
									'database'::'spatial_DB',
									'port'::'8889',
									'user'::'root',
									'passwd'::'root',
								  	"select"::"SELECT geom FROM bounds;" ];
	map<string,string> PARAMS <- [	//'srid'::'32648', // optinal
									'host'::'localhost',
									'dbtype'::'MySQL',
									'database'::'spatial_DB',
									'port'::'8889',
									'user'::'root',
									'passwd'::'root'];
	
	string QUERY <- "SELECT name, type, geom FROM buildings ;";
	geometry shape <- envelope(BOUNDS);		  	
	 	
	init {
		create DB_accessor {
			create buildings from: list(self select [params:: PARAMS, select:: QUERY]) 
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