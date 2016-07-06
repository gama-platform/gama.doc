[//]: # (keyword|statement_remove)
<div class='gama-keyword-style' id ='184_0_618_statement-remove'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='184_1_614_statement-put'></div>
[//]: # (keyword|skill_SQLSKILL)
<div class='gama-keyword-style' id ='184_2_1165_skill-SQLSKILL'></div>
[//]: # (keyword|concept_database)
<div class='gama-keyword-style' id ='184_3_28_concept-database'></div>
#  CreateBuildingTableMySQL ## {#createbuildingtablemysql}


_Author : Truong Minh Thai_

This model shows how to create a database and a table in MySQL using GAMA
 

Code of the model : 

```
model CreateBuildingTableMySQL


global {
			map<string,string> PARAMS <- ['host'::'localhost','dbtype'::'MySQL','database'::'','port'::'8889','user'::'root','passwd'::'root'];
	init {
		create species: test_species number: 1;
		ask test_species {
			if (self testConnection[params::PARAMS]){

 			    do executeUpdate    params:PARAMS updateComm: "CREATE DATABASE spatial_DB_GAMA";
 			    write "spatial_BD_GAMA database was created ";

 			    remove "database" from: PARAMS;
				put "spatial_DB_GAMA" key:"database" in: PARAMS;

				do executeUpdate params: PARAMS
								  updateComm : "CREATE TABLE bounds"+
								  "( "  +
				                    " geom GEOMETRY " +
				                  ")";
				write "bounds table was created ";

				do executeUpdate params: PARAMS
								  updateComm : "CREATE TABLE buildings "+
								  "( "  +
				                   	" name VARCHAR(255), " +
				                    " type VARCHAR(255), " +
				                    " geom GEOMETRY " +
				                  ")";
                write "buildings table was created ";
 			}else {
 				write "Connection to MySQL can not be established ";
 			}
		}
	}
}

species test_species skills: [ SQLSKILL ] { }

experiment default_expr type: gui {

}
```