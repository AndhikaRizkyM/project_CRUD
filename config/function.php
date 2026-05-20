<?php
function statusSuccess($status, $location)
{
  return "<div class='alert alert-success' role='alert'>$status
</div>
<script>
  setTimeout(function() {
  window.location.href = '$location';
  }, 5000);
</script>";
}
