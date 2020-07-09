<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="app">
      <vue-avatar
      :width=400
      :height=400
      :rotation="rotation"
      :scale="scale"
      ref="vueavatar"
      @vue-avatar-editor:image-ready="onImageReady"
      >
    </vue-avatar>
    <br>
    <input
      type="range"
      min=1
      max=3
      step=0.02
      v-model='scale'
    />
    <!-- <input
      type="range"
      min=1
      max=3
      step=0.02
      v-model='rotation'
    /> -->
    <br>
    <button v-on:click="saveClicked">Click</button>
    <br>
    <img ref="image">
</div>
<script src="dist/main.js"></script>
</body>
</html>