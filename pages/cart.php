<?php

require_once('config/paniers.class.php');

?>
<div class="container">
    <h1 align="center"><i class='bx bxs-cart bx-border-circle'></i>La liste des commandes</h1>
</div>
<div class="container-fluid">
	<form method="post" action="#">
		<table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						    <tr>
              <td data-th="Product">
                <div class="row">
                  <div class="col-sm-2 hidden-xs"><img src="assets/img/produit/Hand Crean.png"width="90px" height="90px" alt="Hand Crean" class="img-responsive"/></div>
                  <div class="col-sm-10">
                    <h4 class="nomargin">Hand Crean</h4>
                    <p>Contient de la vitamine A, C, E qui permet à la main d'être lisse, fraîche et aide la main à rester jeune.</p>
                  </div>
                </div>
              </td>
              <td data-th="Price">4 000 FCFA</td>
              <td data-th="Quantity">
                <input type="number" class="form-control text-center" value="1">
              </td>
              <td data-th="Subtotal" class="text-center">4 000</td>
              <td class="actions" data-th="">
                <button class="btn btn-info btn-sm" title="refresh ou édité"><i class='bx bx-refresh'></i></button>
                <button class="btn btn-danger btn-sm" title="trash ou supprimé"><i class='bx bxs-trash'></i></i></button>               
              </td>
            </tr>
					</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total 4 000</strong></td>
						</tr>
						<tr>
							<td><a href="index.php?page=sing" class="btn btn-warning"><i class='bx bxs-chevron-left'></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-center"><strong>Total 4 000 FCFA</strong></td>
							<td><a href="#" class="btn btn-success btn-block">Commander</a></td>
						</tr>
					</tfoot>
				</table>
	</form>	
</div>