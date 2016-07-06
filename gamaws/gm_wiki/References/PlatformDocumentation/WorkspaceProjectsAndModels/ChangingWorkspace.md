
# Changing Workspace ## {#changing-workspace}

It is possible, and actually common, to store different projects/models in different workspaces and to tell GAMA to switch between these workspaces. Doing so involves being able to create one or several new workspace locations (even if GAMA has been told to [remember](references#Launching#Choosing_a_Workspace){.internal-link-anchor} the current one) and being able to easily switch between them.

## Table of contents  ## {#table-of-contents}

* [Changing Workspace](references#changing-workspace)
	* [Switching to another Workspace](references#switching-to-another-workspace)
	* [Cloning the Current Workspace](references#cloning-the-current-workspace)



## Switching to another Workspace ## {#switching-to-another-workspace}
This process is similar to the [choice of the workspace location](references#Launching#Choosing_a_Workspace){.internal-link-anchor} when GAMA is launched for the first time. The only preliminary step is to invoke the appropriate command ("Switch Workspace") from the "File" menu.

![images/menu_switch.png](gm_wiki/resources/images/workspaceProjectsAndModels/menu_switch.png){.img-responsive}

In the dialog that appears, the current workspace location should already be entered. Changing it to a new location (or choosing one in the file selector invoked by clicking on "Browse…") and pressing "OK" will then either create a new workspace if none existed at that location or switch to this new workspace. Both operations will restart GAMA and set the new workspace location. To come back to the previous location, just repeat this step (the previous location is normally now accessible from the combo box).

![images/dialog_switch_ok.png](gm_wiki/resources/images/workspaceProjectsAndModels/dialog_switch_ok.png){.img-responsive}

## Cloning the Current Workspace ## {#cloning-the-current-workspace}
Another possibility, if you have models in your current workspace that you would like to keep in the new one (and that you do not want to [import](references#ImportingModels) one by one after switching workspace), or if you change workspace because you suspect the current one is corrupted, or outdated, etc. but you still want to keep your models, is to **clone** the current workspace into a new (or existing) one.

**Please note that cloning (as its name implies) is an operation that will make a _copy_ of the files into a new workspace. So, if projects are stored in the current workspace, this will result in two different instances of the same projets/models with the same name in the two workspaces. However, for projects that are simply linked from the current workspace, only the link will be copied (which allows to have different workspaces "containing" the same project)**

This can be done by entering the new workspace location and choosing "Clone current workspace" in the previous dialog instead of "Ok".

![images/dialog_switch_clone.png](gm_wiki/resources/images/workspaceProjectsAndModels/dialog_switch_clone.png){.img-responsive}


If the new location does not exist, GAMA will ask you to confirm the creation and cloning using a specific dialog box. Dismissing it will cancel the operation.

![images/clone_confirm_new.png](gm_wiki/resources/images/workspaceProjectsAndModels/clone_confirm_new.png){.img-responsive}


If the new location is already the location of an existing workspace, another confirmation dialog is produced. **It is important to note that all projects in the target workspace will be erased and replaced by the projects in the current workspace if you proceed**. Dismissing it will cancel the operation.

![images/clone_confirm_existing.png](gm_wiki/resources/images/workspaceProjectsAndModels/clone_confirm_existing.png){.img-responsive} 


There are two cases where cloning is not accepted. The first one is when the user tries to clone the current workspace into itself (i.e. the new location is the same as the current location).

![images/close_error_same.png](gm_wiki/resources/images/workspaceProjectsAndModels/close_error_same.png){.img-responsive}

The second case is when the user tries to clone the current workspace into one of its subdirectories (which is not feasible).

![images/close_error_subdir.png](gm_wiki/resources/images/workspaceProjectsAndModels/close_error_subdir.png){.img-responsive}