<script type="text/javascript">

function msg_added(){
  // save msg animation start 
  $("#addedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#addedMsg").transition('fly down'); }, 1000);
    }
  });
  // save msg animation end
}

function msg_saved(){
  // edit msg animation start 
  $("#savedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#savedMsg").transition('fly down'); }, 1000);
    }
  });
  // edit msg animation end
}

function msg_deleted(){
  // delete msg animation start 
  $("#deletedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#deletedMsg").transition('fly down'); }, 1000);
    }
  });
  // delete msg animation end 
}

</script>

<!-- add msg alert start -->
<div id="addedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Added!
  </div>
</div>
<!-- add msg alert end -->


<!-- save msg alert start -->
<div id="savedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Saved!
  </div>
</div>
<!-- save msg alert end -->

<!-- delete msg alert start -->
<div id="deletedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center yellow inverted aligned segment" style="width: 120px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Removed!
  </div>
</div>
<!-- delete msg alert end -->