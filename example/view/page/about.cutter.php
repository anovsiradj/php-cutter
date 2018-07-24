<?php cutter_start('js') ?>
<script src="//anovsiradj.github.io/readme5/readme5.js"></script>
<script>
	var el = document.getElementsByTagName('article')[0];
	el.id = 'my_awesome_readme';
	(new Readme5(el)).init(['../README.md?_=', Date.now()].join(''));
</script>
<?php cutter_end() ?>
