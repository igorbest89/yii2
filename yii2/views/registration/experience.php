<?php
/**
 * @var $id integer
 * @var $years array
 * @var $months array
 * @var $countries array
 */

?>

<div class="experience-block">
    <div class="create-space-between">
        <input name="experience[<?php echo $id; ?>][employer]" type="text" class="input-base create-input350"
               placeholder="Employer">
        <input name="experience[<?php echo $id; ?>][job]" type="text" class="input-base create-input350"
               placeholder="Job Title">
    </div>
    <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="experience[<?php echo $id; ?>][country]"
                                class="create-select select-base create-input350 choice-edit"><option
                                    value="">Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
        <input name="experience[<?php echo $id; ?>][location]" type="text" class="input-base create-input350"
               placeholder="Location">
    </div>
    <textarea name="experience[<?php echo $id; ?>][achievements]" placeholder="Achievements and responsibilities"
              class="create-textarea"></textarea>
    <div class="add-experience">
        <div class="time-from">
            <p class="month-at">Time period from</p>
            <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="experience[<?php echo $id; ?>][from-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                <span class="choice-edit">
                                <select name="experience[<?php echo $id; ?>][from-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Year</option>
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
                                <input name="experience[<?php echo $id; ?>][current]" type="checkbox">
                                <label for="cur-work">I currently work here</label>
                            </span>
            </div>
            <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="experience[<?php echo $id; ?>][to-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                <span class="choice-edit">
                                <select name="experience[<?php echo $id; ?>][to-year]"
                                        class="create-select select-base create-input159 choice-edit"><option value="">Year</option>
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
            </div>
        </div>
    </div>
</div>