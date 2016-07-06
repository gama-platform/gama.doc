[//]: # (keyword|skill_SQLSKILL)
<div class='gama-keyword-style' id ='172_0_1165_skill-SQLSKILL'></div>
[//]: # (keyword|concept_database)
<div class='gama-keyword-style' id ='172_1_28_concept-database'></div>
#  Agents from Database in MSSQL ## {#agents-from-database-in-mssql}


_Author : Benoit Gaudou_

 This model does SQl query commands and create agents using the results


Code of the model : 

```
model DB2agentMSSQL

global {
	map<string,string> BOUNDS <- [	//"srid"::"32648", // optinal
									"host"::"localhost",
									"dbtype"::"sqlserver",
									"database"::"spatial_DB",
									"port"::"1433",
									"user"::"sa",
									"passwd"::"tmt",
								  	"select"::"SELECT GEOM.STAsBinary() as GEOM FROM bounds;" ];
	map<string,string> PARAMS <- [	//"srid"::"32648", // optinal
									"host"::"localhost",
									"dbtype"::"sqlserver",
									"database"::"spatial_DB",
									"port"::"1433",
									"user"::"sa",
									"passwd"::"tmt"];
	
	string QUERY <- "SELECT name, type, GEOM.STAsBinary() as GEOM FROM buildings ;";
	geometry shape <- envelope(BOUNDS);		  	
	init {
		create DB_accessor {
			create buildings from: (self select [params:: PARAMS, select:: QUERY]) 
							 with:[ "name"::"name","type"::"type", "shape":: geometry("geom")];
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

experiment DB2agentMSSQL type: gui {
	output {
		display fullView {
			species buildings aspect: default;
		}
	}
}
```