
# Workpace, Projects and Models ## {#workpace-projects-and-models}



The **workspace** is a directory in which GAMA stores all the current projects on which the user is working, links to other projects, as well as some meta-data like preference settings, current status of the different projects, [error markers](references#ValidationOfModels), and so on.

Except when running in [headless mode](references#Headless), **GAMA cannot function without a valid workspace**.

The workspace is organized in 3 **[categories](references#NavigatingWorkspace)**, which are themselves organized into **projects**.

The **projects** present in the **workspace** can be either directly _stored_ within it (as sub-directories), which is usually the case when the user [creates](references#EditingModels#Creating_a_first_model){.internal-link-anchor} a new project, or _linked_ from it (so the workspace will only contain a link to the directory of the project, supposed to be somewhere in the filesystem or on the network). A same **project** can be linked from different **workspaces**.

**GAMA models files** are stored in these **projects**, which may contain also other files (called _resources_) necessary for the **models** to function. A project may of course contain several **model files**, especially if they are importing each other, if they represent different views on the same topic, or if they share the same resources.

Learning how to [navigate](references#NavigatingWorkspace) in the workspace, how to [switch](references#ChangingWorkspace) workspace or how to [import, export](references#ImportingModels) is a necessity to use GAMA correctly. It is the purpose of the following sections.

* 1. [Navigating in the Workspace](references#NavigatingWorkspace)
* 2. [Changing Workspace](references#ChangingWorkspace)
* 3. [Importing Models](references#ImportingModels)