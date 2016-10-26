
This is a comment

Remember:
in this page, make the navigation inline.

<?php cutter_start('js') ?>
	<script>
		document.getElementById('main').onclick = function() {
			this.insertAdjacentHTML('afterend', this.outerHTML);
		};
	</script>
<?php cutter_end() ?>

<?php cutter_start('content') ?>
	<h1>huwala! (click me)</h1>
<?php cutter_end() ?>

<?php cutter_start('css') ?>
	<style>
		#header {
			text-align: center;
		}
		#me, #nav {
			display: inline-block;
		}
		#me {
			width: 59%;
		}
		#nav {
			width: 39%;
		}
	</style>
<?php cutter_end() ?>
