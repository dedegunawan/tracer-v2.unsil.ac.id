
    <div class="row">
      <div class="input-field col 12">
          <p class="flow-text"><?php echo $pertanyaan;?></p>
      </div>
    </div>

    <?php
    if (is_array($pilihan)) {
        foreach ($pilihan as $key => $value) {
            ?>
            <div class="row">
              <div class="input-field col s6">
                  <input name="jawaban" type="radio" id="pilihan<?php echo $key;?>" value="<?php echo $key;?>"/>
                  <label for="pilihan<?php echo $key;?>"><?php echo $value;?></label>
              </div>
            </div>
            <?php
        }
    }
     ?>
