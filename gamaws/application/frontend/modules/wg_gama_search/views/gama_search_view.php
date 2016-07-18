<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<div class="container gama-content-header-margin gama-search-page">
    <div class="col col-md-10 col-md-offset-1">
        <div class="search-input">
            <div class="input-container">
                <input type="text" id="search-content" onkeyup="autocomplet()" placeholder="search ..." />
            </div>
        </div>

        <div>
            <div align="center" style="display: none;" id="loading">
                <p><img src="<?php echo gama_assets_url()?>/img/ajax-loader.gif" /> Please Wait</p>
            </div>
            <ul id="search-result" class="search-result-style">
                <li class="input-container-header"></li>
            </ul>
        </div>

    </div>
</div>

<script>

    // autocomplet : this function will be executed every time we change the text
    /*function autocomplet() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#country_id').val();
        if (keyword.length >= min_length) {
            jQuery.ajax({
                url: 'gama_search_ajax_view.php',
                type: 'POST',
                data: {keyword:keyword},
                success:function(data){
                    $('#country_list_id').show();
                    $('#country_list_id').html(data);
                }
            });
        } else {
            $('#country_list_id').hide();
        }
    }*/

    function autocomplet() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#search-content').val();
        if (keyword.length > min_length) {
            jQuery.ajax({
                url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getKeywordList");?>',
                type: 'POST',
                data: {keyword:keyword},
                success:function(data){
                    $('#search-result').show();
                    $('#search-result').html(data);
                }
            });
        } else {
            $('#search-result').hide();
        }
    }

    // set_item : this function will be executed when we select an item
    function setItem(item, id) {
        // change input value
        $('#search-content').val(item);
        // hide proposition list
        $('#search-result').hide();

        var keyword_id = id;
        jQuery.ajax({
            url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getWebpageList");?>',
            type: 'POST',
            data: {keyword_id:keyword_id},
            success:function(data){
                $('#search-result').show();
                $('#search-result').html(data);
            }
        });

    }
</script>
