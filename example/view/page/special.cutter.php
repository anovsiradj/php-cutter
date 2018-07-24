
This is a comment

Remember:
in this page, make the page cooler.

<?php cutter_begin('content') ?>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse pariatur saepe, soluta adipisci quaerat porro autem voluptas doloribus. Earum ex, nam ducimus voluptatem perspiciatis minus quaerat voluptas harum error!
<?php cutter_end() ?>

<?php cutter_start('css') ?>
<style>
	html {
		background-color: aqua;
	}

	h1 {
		font-family: monospace;
		background-color: red;
		display: inline-block;
		padding: 4px 8px;
	}

	article {
		position: relative;
		padding: 4px 8px;
		margin-top: 10px;
		background-color: yellow;
	}

	nav a {
		background-color: lime;
		padding: 2px 4px;
		text-decoration: none;
	}

	footer {
		text-align: right;
		position: relative;
	}

	footer b {
		font-family: monospace;
		background-color: #0099ff;
		padding: 2px 4px;
		position: absolute;
		right: 0px;
		bottom: -24px;
	}

	body {
		width: 64%;
		margin: 0px auto;
		background-color: gray;
		margin-top: 16px;
	}
</style>
<?php cutter_stop() ?>
