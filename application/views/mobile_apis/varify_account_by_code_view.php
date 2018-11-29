<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if($success == 1 ): ?>
    <h1 style="color:green;">Your account varified successfully. </h1>
<?php else: ?>
    <h1 style="color:red;">There is problem in your account varification, Please contact the department for more information </h1>
<?php endif; ?>

<script type="text/javascript">
function closeWindow() {
setTimeout(function() {
window.close();
}, 5000);
}

window.onload = closeWindow();
</script>