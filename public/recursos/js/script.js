function showmenu (){
	var menu = document.getElementById('menu');
	var body = document.getElementsByTagName('body')[0];
	menu.classList.toggle('mostrar-menu');
	body.classList.toggle('overflow-hidden');
}