
<?php $cutter->begin('js') ?>
<script src="//anovsiradj.github.io/readme5/readme5.js"></script>
<script>
	var el = document.querySelector('article');
	el.id = 'my_awesome_readme';
	(new Readme5(el)).init(['../README.md?_=', Date.now()].join(''));
</script>
<?php $cutter->end() ?>
