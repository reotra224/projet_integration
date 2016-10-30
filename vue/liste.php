
<?php foreach ($list as $v){
			if($v->anonymat()=="1") {?>
				<div class="div_sign">
					<p>
						<?php echo $v->message(); ?>
					</p>
					<div class="img"><?php echo $v->pseudo(); ?></div>
				</div>
	<?php }
			else{?>
				<div class="div_sign">
					<p>
						<?php echo $v->message(); ?>
					</p>
					<div class="img">
						<img src="<?php echo $v->photo(); ?>" height="40px">
						<?php echo $v->nom_complet(); ?>
					</div>
				</div>
	<?php }
	} ?>
