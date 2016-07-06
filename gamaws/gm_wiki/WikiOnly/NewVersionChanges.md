# Changes between 1.6.1 and 1.7 that can influence the dynamics of models ## {#changes-between-161-and-17-that-can-influence-the-dynamics-of-models}

* Initialization order between the initialization of variables and the execution of the `init` block in grids
init -> vars in 1.6.1 / vars -> init in 1.7
* Initialization order of agents -> now, the init block of the agents are not executed at the end of the global init, but during it.
put a sample model to explain the order of creation and its differences
* Initialization of vars to their default value
map ? list ? 
* Systematic casting and verification of types
give examples
* header of CSV files: be careful, in GAMA 1.7, if the first line is detected as a header, it is not read when the file is casted as a matrix (so the first row of the matrix is not the header, but the first line of data)
gives examples
* the step of batch experiments is now executed after all repetitions of simulations are done (not after each one). They can however be still accessed using the attributes `simulations` (see Batch.gaml in Models Library)
* signal and diffuse have been merged into a single statement
* facets do not accept a space between their identifier and the `:` anymore.
* simplification of equation/solve statements and deprecation of old facets

# Enhancements in 1.7 ## {#enhancements-in-17}
* multi-simulation
* date : new variable type and possibility to use a real calendar
* font in draw
* draw of complex shapes through obj file
* new types fo files are taken into account: geotiff and dxf
* viewers for common files
* editor: doc on built-in elements, templates, shortcuts to common tasks, hyperlinks to files used
* validation: improvement in time, gathering of infos/todos
* navigator: better overview of model files and their support files, addition of plugin models
* Models library: 
* Preferences: for performances and bug fixes in displays
* Simulation views
* Error view
* BDI control architecture for agents
* language: file management, new operators, new statements, new skills(?), new built-in variables, 
* status statement (to manipulate the status line from GAML)
* fullscreen mode for displays (ESC key)
* new operators (sum_of, etc.)
* cleaner OpenGL displays (less garbage, better drawing of lines, rotation helper, sticky ROI, etc.)
* faster java2D displays (esp. on zoom)
* casting of files works
* co-modeling
* better user interaction (mouse move, hover, key listener)
* warnings can be removed from model files
* getting values when moving the mouse on charts
* populations of agents can now be easily exported to CSV files using the `save` statement
* monitors can have colors
* light statement in 3D display provides the possibility to custom your lights (point lights, direction lights, spot lights)