# Changes between 1.6.1 and 1.7 that can influence the dynamics of models

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
* in FIPA skill, `content`is replaced everywhere with `contents`
* in FIPA skill, `receivers` is replaced everywhere with `to`
* in FIPA skill, `messages` is replaced by `mailbox`

# Enhancements in 1.7

* Simulations
 * multi-simulation

* Language
 * date : new variable type and possibility to use a real calendar
 * font in draw
 * BDI control architecture for agents
 * file management, new operators, new statements, new skills(?), new built-in variables, 
 * status statement (to manipulate the status line from GAML)
 * new operators (sum_of, etc.)
 * casting of files works
 * co-modeling (importation of micro-models that can be managed within a macro-model)
 * populations of agents can now be easily exported to CSV files using the `save` statement 
 * Simple messaging skill between agents  
 * Terminal commands can now be issued from within GAMA using the `console` operator
 * New `status` statement allows to change the text of the status.
 * light statement in 3D display provides the possibility to custom your lights (point lights, direction lights, spot lights)

* Data importation
 * draw of complex shapes through obj file
 * new types fo files are taken into account: geotiff and dxf
 * viewers for common files
 * navigator: better overview of model files and their support files, addition of plugin models 

* Editor
 * doc on built-in elements, templates, shortcuts to common tasks, hyperlinks to files used
 * improvement in time, gathering of infos/todos
 * warnings can be removed from model files


* Models library: 
 * New models (make a list)

* Preferences
 * For performances and bug fixes in displays

* Simulation displays
 * fullscreen mode for displays (ESC key)
 * CTRL+O for overlay and CTRL+L for layers side controls
 * cleaner OpenGL displays (less garbage, better drawing of lines, rotation helper, sticky ROI, etc.)
 * faster java2D displays (esp. on zoom)
 * better user interaction (mouse move, hover, key listener)
 * a whole new set of charts
 * getting values when moving the mouse on charts
 * Changing simulation names is reflected in their display titles (and it can be dynamic)

* Error view
 * Much faster (up to 100x !) display of errors
 * Contextual menu to copy the text of errors to clipboard or open the editor on it

* Console
 * Interactive console allows to directly interact with agents (experiments, simulations and any agent) and get a direct feedback on the impact of code execution using a new interpreter integrated with the console.
 * Console now accepts colored text output 

* Monitor view
 * monitors can have colors

* Serialization
 * Serialize simulations and replay them (to come)
 * Serialization and deserialization of agents between simulations (to come)

* Allow TCP, UDP and MQQT communications between agents in different simulations (to come)