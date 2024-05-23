document.getElementById("uploadForm").onsubmit = function (event) {
  event.preventDefault();

  var fileInput = document.getElementById("fileToUpload");
  if (fileInput.files.length === 0) {
    alert("Veuillez sélectionner un fichier.");
    return;
  }

  var formData = new FormData();
  formData.append("fileToUpload", fileInput.files[0]);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "upload.php", true);

  xhr.upload.onprogress = function (event) {
    if (event.lengthComputable) {
      var percentComplete = (event.loaded / event.total) * 100;
      var progressBar = document.getElementById("progressBar");
      progressBar.style.width = percentComplete + "%";
    }
  };

  xhr.onload = function () {
    var messageDiv = document.getElementById("message");
    if (xhr.status == 200) {
      messageDiv.innerHTML = xhr.responseText;
    } else {
      messageDiv.innerHTML = "Une erreur s'est produite lors de l'upload.";
    }
    document.getElementById("progressBarContainer").style.display = "none";
    document.getElementById("progressBar").style.width = "0%";
    setTimeout(function () {
      location.reload();
    }, 3000); // Recharge la page après 3 secondes pour mettre à jour les fichiers disponibles
  };

  document.getElementById("progressBarContainer").style.display = "flex";
  xhr.send(formData);
};

const inputFile = document.querySelector("#fileToUpload");
const btnFile = document.querySelector(".btn");
btnFile.addEventListener("click", () => {
  console.log(btnFile.value);
});
