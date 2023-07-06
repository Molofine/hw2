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

function onResponse(response){
    console.log(response);
    return response.json();
}

function onDBJson(json) {
    console.log(json);

    for(let i=0; i < json.length; i++) {
        const image = document.createElement('img');
        image.classList.add('image');
        image.src = json[i].destination;
        image.addEventListener("click", apriModale);

        const star = document.createElement('img');
        star.classList.add('star');
        star.src = BASE_URL + "img/star.png";
        star.addEventListener("click", preferiti); 

        const desc = document.createElement("article");
        desc.classList.add("dark");
        const alt_desc = document.createElement("article");
        alt_desc.classList.add("dark");
        const author = document.createElement("article");
        author.classList.add("italic");
        const created = document.createElement("article");
        created.classList.add("italic");

        desc.textContent = json[i].descrip;
        alt_desc.textContent = json[i].alt_desc;
        author.textContent = "Uploaded by: " + json[i].username;
        created.textContent = "Uploaded at: " + json[i].created;
        
        const cover = document.createElement('div');
        cover.classList.add('photo');
        cover.dataset.id = json[i].id;
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

function onImgJson(json) {
    console.log(json);

    if (json.total === 0) {
        const section = document.querySelector('#album');
        const avviso = document.createElement('div');
        avviso.classList.add('nessunRisultato');
        avviso.textContent = "Nessun risultato da Unsplash";
        section.appendChild(avviso);
    }

    for(let i=0; i < json.results.length; i++) {
        const image = document.createElement('img');
        image.classList.add('image');
        image.src = json.results[i].urls.regular;
        image.addEventListener("click", apriModale);

        const star = document.createElement('img');
        star.classList.add('star');
        star.src = BASE_URL + "img/star.png";
        star.addEventListener("click", preferiti); 

        const desc = document.createElement("article");
        desc.classList.add("dark");
        const alt_desc = document.createElement("article");
        alt_desc.classList.add("dark");
        const author = document.createElement("article");
        author.classList.add("italic");
        const created = document.createElement("article");
        created.classList.add("italic");

        desc.textContent = json.results[i].description;
        alt_desc.textContent = json.results[i].alt_description;
        author.textContent = "Uploaded by: " + json.results[i].user.name;
        json.results[i].created_at = json.results[i].created_at.substring(0,10);
        created.textContent = "Uploaded at: " + json.results[i].created_at;
        
        const cover = document.createElement('div');
        cover.classList.add('photo');
        cover.dataset.id = json.results[i].id;
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

function cerca(event){
    event.preventDefault();
    const section = document.querySelector('#album');
    section.innerHTML = "";
    const query = document.querySelector("input[type=text]");
    fetch(BASE_URL + "cerca_db/" + encodeURIComponent(query.value)).then(onResponse).then(onDBJson);
    fetch(BASE_URL + "cerca_img/" + encodeURIComponent(query.value)).then(onResponse).then(onImgJson);
}

document.querySelector('form').addEventListener("submit", cerca);