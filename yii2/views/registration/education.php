<?php
/**
 * @var $id integer
 * @var $years array
 * @var $months array
 * @var $courses array
 * @var $countries array
 */

?>

<div class="education-block">
    <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="education[<?php echo $id; ?>][courses]"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Course</option>
                            <?php foreach ($courses as $course) { ?>
                                <option><?php echo $course; ?></option>
                            <?php } ?>
                        </select>
                    </span>
        <input name="education[<?php echo $id; ?>][school]" type="text" class="input-base create-input350"
               placeholder="School Name">
    </div>
    <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="education[<?php echo $id; ?>][country]"
                                class="create-select select-base create-input350 choice-edit">
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
        <input name="education[<?php echo $id; ?>][location]" type="text" class="input-base create-input350"
               placeholder="Location">
    </div>
    <div class="add-study-exp">
        <div class="time-from">
            <p class="month-at">Time period from</p>
            <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="education[<?php echo $id; ?>][from-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                <span class="choice-edit">
                                <select name="education[<?php echo $id; ?>][from-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
            </div>
        </div>
        <div class="time-to">
            <div class="time-to-checkbox">
                <p class="month-to">Time period to</p>
                <span>
                                <input name="education[<?php echo $id; ?>][current]" type="checkbox">
                                <label for="cur-stud">I currently study here</label>
                            </span>
            </div>
            <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="education[<?php echo $id; ?>][to-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                <span class="choice-edit">
                                <select name="education[<?php echo $id; ?>][to-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
            </div>
        </div>
    </div>
    <input name="education[<?php echo $id; ?>][specialization]" type="text" class="input-base create-input100"
           placeholder="Specialization">
    <textarea name="education[<?php echo $id; ?>][description]" placeholder="Description (optional)"
              class="create-textarea-descr"></textarea>
</div>
