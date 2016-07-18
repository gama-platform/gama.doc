<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>

<div class="well">
    <label>Help us fill the form and download. Thank you! </label>
    <div class="input-group">
        <span class="input-group-btn">
                <p class="btn btn-default"><i class="fa fa-2x fa-user"></i></p>
            </span>
        <input type="text" class="form-control">
    </div>
    <h5 class="text-muted">(first name, last name)</h5>

    <div class="input-group">
                    <span class="input-group-btn">
                            <p class="btn btn-default"><i class="fa fa-2x fa-home"></i></p>
                        </span>
        <input type="text" class="form-control">
    </div>
    <h5 class="text-muted">(lab, university, company)</h5>

    <div class="input-group">
                    <span class="input-group-btn">
                            <p class="btn btn-default"><i class="fa fa-2x fa-envelope"></i></p>
                        </span>
        <input type="text" class="form-control">
    </div>
    <h5 class="text-muted">(email address)</h5>

    <div>
        <hr>
        <div class="list-group custom-bullet"><label>How did you hear about GAMA ?</label>
            <ul>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">During a training session / class</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">By a colleague</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Using a search engine</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">I am already a user</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">I am already a user</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Other:</label><input type="text"">
                    </div></li>
            </ul>
        </div>

        <hr>
        <div class="list-group custom-bullet"><label>What do you intend to use GAMA for ?</label>
            <ul>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Support for my own research</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Support for lectures I give</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Support for a multi-partners project</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Support for a student project I have to do</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">To test it</label>
                    </div></li>
                <li><div class="checkbox">
                        <label><input type="checkbox" value="">Other:</label><input type="text"">
                    </div></li>
            </ul>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-default btn-small">
            <i class="fa fa-download fa-fw"></i> <span class="btn-resources">download</span>
        </button>
    </div>
</div>