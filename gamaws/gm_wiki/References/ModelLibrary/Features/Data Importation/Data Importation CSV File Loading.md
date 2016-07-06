[//]: # (keyword|operator_csv_file)
<div class='gama-keyword-style' id ='161_0_248_operator-csv-file'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='161_1_1556_type-matrix'></div>
[//]: # (keyword|concept_csv)
<div class='gama-keyword-style' id ='161_2_26_concept-csv'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='161_3_65_concept-load-file'></div>
# Convertion of CSV data to Matrix ## {#convertion-of-csv-data-to-matrix}


_Author :  Patrick Taillandier_

Model which shows how to initialize a matrix by using the content of a CSV File. The model load a CSV File, and write its content in the console. 


Code of the model : 

```


model CSVfileloading

global {
	file my_csv_file <- csv_file("../includes/iris.csv",",");
	
	init {
		//convert the file into a matrix
		matrix data <- matrix(my_csv_file);
		//loop on the matrix rows (skip the first header line)
		loop i from: 1 to: data.rows -1{
			//loop on the matrix columns
			loop j from: 0 to: data.columns -1{
				write "data rows:"+ i +" colums:" + j + " = " + data[j,i];
			}	
		}		
	}
}

experiment main type: gui;
```