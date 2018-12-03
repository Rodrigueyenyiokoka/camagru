
function like_photo(id){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../my_pages/like.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("imageId=" + id);
    xhr.onreadystatechange = function(event) {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          if ((this.responseText))
            JSON.parse(this.responseText).error
          else
          location.reload();
        }
      }
    };
}