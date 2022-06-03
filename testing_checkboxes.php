<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- You MUST include jQuery before Fomantic -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>

    <script src="node_modules/vue/dist/vue.js"></script>

</head>

<body>
    <div id="test">
        <div v-for="item in items" :key="item.id" class="ui checkbox">
            <input type="radio" :value="item.id" name="itemid">
            <label> TEST  </label>
        </div>
    </div>
    <script>
        new Vue({
            el: "#test",
            data() {
                return {
                    items: [0,1,2,3,4]
                }
            },
            mounted() {
                $('.ui.checkbox').checkbox()
            }
        })
    </script>

</body>

</html>