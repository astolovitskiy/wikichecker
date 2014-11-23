<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 10/7/13
 * Time: 1:55 PM
 * To change this template use File | Settings | File Templates.
 */

?>

<div id="delete_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo 'Confirm'?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo 'Delete record?'?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Cancel'?></button>
				<button type="button" class="btn btn-primary" id="delete_item_button"><?php echo 'Delete'?></button>
			</div>

		</div>
	</div>
</div>