<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
    $wiki_url = base_url("gama.wiki");
?>
<div class="container padding-header">
    <div class="col-md-8 col-md-offset-2 padding-header">
        <?php
            $Parsedown = new Parsedown();
            $test = "/G__Overview";
            $markdown = file_get_contents($wiki_url . $test . '.md');
            echo $Parsedown->text($markdown);
        ?>
    </div>
</div>
