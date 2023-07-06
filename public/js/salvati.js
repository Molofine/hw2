function preferiti(event) {
    const star = event.currentTarget;
    const cover = star.parentNode;
    const image = cover.querySelector('img');

    const formData = new FormData();
    formData.append('id', cover.dataset.id);
    formData.append('description', cover.dataset.desc);
    formData.append('alt_description', cover.dataset.alt_desc);
    formData.append('created', cover.dataset.created);
    formData.append('author', cover.dataset.author);
    formData.append('image', image.src);
    formData.append('_token', csrf_token);
    fetch(BASE_URL + "salva_img/" + cover.dataset.id, {method: 'post', body: formData}).then(onResponse).then((json) => {
		if (json.presente === false) {
            star.src = BASE_URL + 'img/star_pressed.png';
        } else {
            star.src = BASE_URL + 'img/star.png'
        }
	});
}

function cancella(event) {
    const trash = event.currentTarget;
    const cover = trash.parentNode;

    fetch(BASE_URL + "cancella_img/" + cover.dataset.id).then(onResponse);
}

function onResponse(response) {
    console.log(response);
    return response.json();
}

function onUploadJson(json) {
    console.log(json);

    if (json.length === 0) {
        const section = document.querySelector('#posted');
        section.innerHTML = "";

        const avviso = document.createElement('div');
        avviso.classList.add('nessunRisultato');
        avviso.textContent = "Non hai ancora caricato foto";
        section.appendChild(avviso);
    }

    for(let i=0; i < json.length; i++) {
        const image = document.createElement('img');
        image.classList.add('image');
        image.src = json[i].destination;
        image.addEventListener("click", apriModale);

        const trash = document.createElement('img');
        trash.classList.add('star');
        trash.src = "img/trash.png";
        trash.addEventListener("click", cancella);
        trash.addEventListener("click", caricaFotoSalvate);

        const desc = document.createElement("article");
        desc.classList.add("dark");
        const alt_desc = document.createElement("article");
        alt_desc.classList.add("dark");
        const created = document.createElement("article");
        created.classList.add("italic");

        desc.textContent = json[i].descrip;
        alt_desc.textContent = json[i].alt_desc;
        created.textContent = "Uploaded at: " + json[i].created;
        
        const cover = document.createElement('div');
        cover.classList.add('photo');
        cover.dataset.id = json[i].id;
        cover.dataset.desc = desc.textContent;
        cover.dataset.alt_desc = alt_desc.textContent;
        cover.dataset.created = created.textContent;
        
        cover.appendChild(image);
        cover.appendChild(trash);
        cover.appendChild(desc);
        cover.appendChild(alt_desc);
        cover.appendChild(created);

        const section = document.querySelector('#posted');
        section.appendChild(cover);
    }
}

function onDBJson(json) {
    console.log(json);

    if (json.length === 0) {
        const section = document.querySelector('#album');
        section.innerHTML = "";

        const avviso = document.createElement('div');
        avviso.classList.add('nessunRisultato');
        avviso.textContent = "Non hai ancora salvato nessuna foto";
        section.appendChild(avviso);
    }

    for(let i=0; i < json.length; i++) {
        const image = document.createElement('img');
        image.classList.add('image');
        image.src = json[i].info.image;
        image.addEventListener("click", apriModale);

        const star = document.createElement('img');
        star.classList.add('star');
        star.src = "img/star_pressed.png";
        star.addEventListener("click", preferiti);
        star.addEventListener("click", caricaFotoSalvate);

        const desc = document.createElement("article");
        desc.classList.add("dark");
        const alt_desc = document.createElement("article");
        alt_desc.classList.add("dark");
        const author = document.createElement("article");
        author.classList.add("italic");
        const created = document.createElement("article");
        created.classList.add("italic");

        desc.textContent = json[i].info.description;
        alt_desc.textContent = json[i].info.alt_description;
        author.textContent = json[i].info.author;
        created.textContent = json[i].info.created;
        
        const cover = document.createElement('div');
        cover.classList.add('photo');
        cover.dataset.id = json[i].imgid;
        cover.dataset.desc = desc.textContent;
        cover.dataset.alt_desc = alt_desc.textContent;
        cover.dataset.author = author.textContent;
        cover.dataset.created = created.textContent;
        
        cover.appendChild(image);
        cover.appendChild(star);
        cover.appendChild(desc);
        cover.appendChild(alt_desc);
        cover.appendChild(author);
        cover.appendChild(created);

        const section = document.querySelector('#album');
        section.appendChild(cover);
    }
}

function cancellaAccount(event) {
    fetch(BASE_URL + "cancella_account").then(onResponse);
    message = document.querySelector('#delete h6');
    message.textContent = "Account Cancellato";
}

function caricaFotoSalvate() {
    const uploaded = document.querySelector("#posted");
    uploaded.innerHTML = "";
    fetch(BASE_URL + "carica_upload").then(onResponse).then(onUploadJson);
    const section = document.querySelector('#album');
    section.innerHTML = "";
    fetch(BASE_URL + "carica_db").then(onResponse).then(onDBJson);
}

caricaFotoSalvate();

const deleteAccount = document.querySelector('button');
deleteAccount.addEventListener('click', cancellaAccount);