[//]: # (keyword|statement_remove)
<div class='gama-keyword-style' id ='185_0_618_statement-remove'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='185_1_614_statement-put'></div>
[//]: # (keyword|skill_SQLSKILL)
<div class='gama-keyword-style' id ='185_2_1165_skill-SQLSKILL'></div>
[//]: # (keyword|concept_database)
<div class='gama-keyword-style' id ='185_3_28_concept-database'></div>
#  CreateBuildingTablePostGIS ## {#createbuildingtablepostgis}


_Author : Truong Minh Thai_

This model shows how to create a database and a table in PostGIS using GAMA
 

Code of the model : 

```

model CreateBuildingTablePostGIS


global {
	map<string,string> PARAMS <-  ['host'::'localhost','dbtype'::'Postgres','database'::'','port'::'5433','user'::'postgres','passwd'::'tmt'];

	init {
		create dummy ;
		ask dummy {
			if (self testConnection[ params::PARAMS]){
				
 			    do executeUpdate    params:PARAMS updateComm: "CREATE DATABASE spatial_db with TEMPLATE = template_postgis;"; 
 			    write "spatial_BD database was created ";
 			    remove key: "database" from: PARAMS;
				put "spatial_db" key:"database" in: PARAMS;
				do executeUpdate params: PARAMS 
				  updateComm : "CREATE TABLE bounds"+
				  "( "  +
                    " geom GEOMETRY " + 
                  ")";
				write "bounds table was created ";
				do executeUpdate params: PARAMS 
				  updateComm : "CREATE TABLE buildings "+
				  "( "  +
                   	" name character varying(255), " + 
                    " type character varying(255), " + 
                    " geom GEOMETRY " + 
                  ")";
                write "buildings table was created ";
 			}else {
 				write "Connection to MySQL can not be established ";
 			}	
		}
	}
}

species dummy skills: [ SQLSKILL ] { }
   
experiment default_expr type: gui {

}
```