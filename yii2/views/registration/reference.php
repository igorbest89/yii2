<?php
/**
 * @var $id integer
 */

?>

<div class="references-contacts">
    <div class="create-space-between">
        <input name="references[<?php echo $id; ?>][name]" type="text" class="input-base create-input350"
               placeholder="Name">
        <input name="references[<?php echo $id; ?>][surname]" type="text" class="input-base create-input350"
               placeholder="Surname">
    </div>
    <div class="create-space-between">
        <input name="references[<?php echo $id; ?>][job]" type="text" class="input-base create-input350"
               placeholder="Job Title">
        <input name="references[<?php echo $id; ?>][company]" type="text" class="input-base create-input350"
               placeholder="Company Name">
    </div>
    <div class="create-space-between rem-margin">
        <input name="references[<?php echo $id; ?>][phone]" type="text" class="input-base create-input350"
               placeholder="Phone Number">
        <input name="references[<?php echo $id; ?>][email]" type="email" class="input-base create-input350"
               placeholder="Email">
    </div>
</div>
