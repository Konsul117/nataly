document.getElementById('button-search').addEventListener('click', function(e) {
	document.querySelector('nav').classList.toggle('is-search');

	e.preventDefault();
});
