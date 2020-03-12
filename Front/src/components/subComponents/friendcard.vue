<template>
<div class="card mb-3" style="max-width:600px;">
<div style="  border: 1px solid;
 padding: 10px;
 box-shadow: 5px 10px #888888;
 border-radius:5px;">
<div class="row no-gutters">
<div class="col-md-4">
<img src="F:\picture\Screenshots\thunder.jpg" class="card-img" alt="...">
</div>
<div class="col-md-8">
<div class="card-body">
  <h5 class="card-title">The Thunder</h5>
  <div style="width: 200px;overflow:hidden;height:80px;">
<p> My bio Helooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo</p>
</div>
<a href="#" class="btn btn-primary" title="Dismissible popover" data-toggle="popover" data-trigger="focus" data-content="Click anywhere in the document to close this popover">Read more</a>
<a href="#" class="btn btn-primary">Unfriend</a>
<a href="#" class="btn btn-primary">Block</a>
</div>
</div>
</div>
</div>
</div>
</template>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>

<style>
</style>
