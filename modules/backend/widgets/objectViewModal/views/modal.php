<?php

?>
<div id="ygin-modal-view" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        var $modalView = $('#ygin-modal-view');
        $(this).on('click','.js-view-model',function(event){

            var $item = $(this);
            $.ajax({
                type: "POST",
                url: $item.attr('href'),
                data: {
                    '<?= ObjectUrlRule::PARAM_ACTION_VIEW_AJAX ?>' : 'true'
                },
                success: function(viewHtml){
                    var instanceId = $item.closest('tr').attr('id').replace('ygin_inst_','');
                    $modalView.find('.modal-title').html( instanceId );
                    $modalView.find('.modal-body').html( viewHtml );
                    $modalView.modal();
                }
            });
            event.preventDefault();
            
        });
    });
</script>
