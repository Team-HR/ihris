<?php require_once 'header.php'?>
<div class="ui container">
    <div class="ui segment">
<!--  -->
<img id="output" width="100" height="100">
<input type="file" accept="image/*" id="file-input">

    <!--  -->
    </div>
</div>

<script>
  const fileInput = document.getElementById('file-input');

  fileInput.addEventListener('change', (e) => doSomethingWithFiles(e.target.files));


  const output = document.getElementById('output');

function doSomethingWithFiles(fileList) {
  let file = null;

  for (let i = 0; i < fileList.length; i++) {
    if (fileList[i].type.match(/^image\//)) {
      file = fileList[i];
      break;
    }
  }

  if (file !== null) {
    output.src = URL.createObjectURL(file);
  }
}
</script>

<?php require_once 'footer.php'?>