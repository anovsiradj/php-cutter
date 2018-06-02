<?php cutter_start('js') ?>
<script src="//anovsiradj.github.io/readme5/readme5.js"></script>
<script>
	document.getElementsByTagName('article')[0].id = 'my_awesome_readme';
	(new Readme5('my_awesome_readme')).init(['../README.md?_=', Date.now()].join(''));
</script>
<?php cutter_end() ?>
