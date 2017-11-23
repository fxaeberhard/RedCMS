<div class="dates">

	@if (request('ref'))
		<?php include app_path() . '/../../date_details-nofooter.php';?>

	@else
		<div class="dates-next">
			<!-- <h1>Next Dates</h1> -->
			<?php include app_path() . '/../../dates_next-nofooter.php';?>
		</div>
<br>
<br>
		<div class="dates-prev">
			<!-- <h1>Past Dates</h1> -->
			<?php include app_path() . '/../../dates_prev-nofooter.php';?>
		</div>

	@endif

</div>