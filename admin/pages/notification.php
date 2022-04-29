<?php

$comm = getcomments();

if (isset($_POST['Modifier'])) {
  $id = $_POST['id'];

  if (!empty($Nom) && !empty($t) && is_numeric($id)) {
    $requery = $db->prepare("update commentaire set seen ='1' WHERE id=$id");
    $db->exec($requery);
  }
}

?>
<main class="page-content main">
	<h1 align="center">Commentaires non lus </h1>
	<table class="table table-borderd table-hover table-stripped">
		<thead>
			<tr>
				<th class="w-25">Articles</th>
				<th class="w-25">Commentaire</th>
				<th class="w-25">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($comm as $Commentaire) {
					?>
					<tr id="commentaire_<?= $Commentaire->id?>">
						<td><?= $Commentaire->titre ?></td>
						<td><?= substr($Commentaire->comment,0,100);?>...</td>
						<td>
							<a href="#" id="<?=$Commentaire->id?>" class="see_comment"><i class='bx bx-check bx-border-circle bx-sm'></i></a>
							<a href="#" id="<?=$Commentaire->id?>" class="delete_comment"><i class='bx bxs-trash bx-border-circle bx-sm'></i></a>
							<a href="#commentaire_<?= $Commentaire->id?>" data-toggle="modal" data-target="#modal-trigger<?= $Commentaire->id?>" class="modal-trigger"><i class='bx bx-dots-vertical-rounded bx-border-circle bx-sm'></i></a>

							<div class="modal"id="modal-trigger<?= $Commentaire->id?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title"><?=$Commentaire->titre;?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="row mb-5">
												<div class="media">
													<img class="mr-3" src="../assets/img/produit/<?=$Commentaire->titre?>"alt="<?=$Commentaire->titre?>"style="width:60px">
													<div class="media-body">
														<h5 class="mt-0"><strong><?= htmlentities($Commentaire->nom);?>, <?=$Commentaire->email ?>, Le (<?=date("d/m/Y", strtotime($Commentaire->date))?>)</strong></h5>
														<?= htmlentities($Commentaire->comment);?>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<a id="<?=$Commentaire->id?>" class="see_comment"data-dismiss="modal" title="lire"name="Modifier"><i class='bx bx-check bx-border-circle bx-sm'></i></a>
											<a href="#" id="<?=$Commentaire->id?>" class="delete_comment"data-dismiss="modal"><i class='bx bxs-trash bx-border-circle bx-sm'></i></a>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<?php
				}

			?>
		</tbody>
	</table>
</main>