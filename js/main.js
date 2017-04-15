moreBtn = document.querySelectorAll(".moreBtn");


function makeRequest(){
		httpRequest = new XMLHttpRequest();

		if(!httpRequest){
			console.log('please update browser');
			return false;
		}
		//console.log(this.id);
		httpRequest.onreadystatechange = showmore;
		httpRequest.open('GET', 'phpscripts/ajaxQuery.php' + '?movie=' + this.id);
		httpRequest.send();
	}

function showmore(){
	if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
		var movieInfo = JSON.parse(httpRequest.responseText);

		hidden = document.querySelector("#movie"+movieInfo.movies_id);
		descText = document.querySelector("#movie"+movieInfo.movies_id+" p");
		time = document.querySelector("#movie"+movieInfo.movies_id+" h3");
		price = document.querySelector("#movie"+movieInfo.movies_id+" h4");
		vid = document.querySelector("#movie"+movieInfo.movies_id+" video");

		descText.innerHTML = movieInfo.movies_storyline;
		time.innerHTML = "Run Time: " + movieInfo.movies_runtime;
		price.innerHTML = "Price: " +movieInfo.movies_price;
		//console.log(hidden);
		vid.src = "videos/"+movieInfo.movies_trailer;
		//console.log(vid.src);

		hidden.classList.toggle("hide");
	}
}

for (i = 0; i < moreBtn.length; i++){
	moreBtn[i].addEventListener("click",makeRequest,false);
}