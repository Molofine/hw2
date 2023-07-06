function apriModale(event) {
	const image = document.createElement('img');
	image.src = event.currentTarget.src;
	modale.appendChild(image);
    const closeButton = document.createElement('img');
    closeButton.src = "/img/close.png";
    closeButton.classList.add('close-btn');
    modale.appendChild(closeButton);
    closeButton.addEventListener('click', chiudiModale);
	modale.classList.remove('hidden');
	document.body.classList.add('no-scroll');
}

function chiudiModale(event) {
    modale.classList.add('hidden');
    modale.innerHTML = "";
    document.body.classList.remove('no-scroll');
}

function chiudiModaleEsc(event) {
    if(event.key === 'Escape') {
        modale.classList.add('hidden');
        modale.innerHTML = "";
        document.body.classList.remove('no-scroll');
    }
}

const modale = document.querySelector('#modal');
//modale.addEventListener('click', chiudiModale);
window.addEventListener('keydown', chiudiModaleEsc);