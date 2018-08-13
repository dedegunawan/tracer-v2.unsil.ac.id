<div class="row">

    <div class="col-md-4 col-md-offset-4">
        <div class="form-group text-center">
            <label>Pilih Menu</label>
            <select name="optx" id="optx" class="form-control">
                <option value="0">
                    --Pilih Salah Satu--
                </option>
                <?php
                foreach ($pertanyaans as $key => $pertanyaan) {
                    ?>
                    <option value="p<?=$key;?>"
                        <?php
                        if (@$selected == "p$key") {
                            echo " selected='selected' ";
                        }
                        ?>

                    >
                        <?=@$pertanyaan;?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <script>
    function changer($el, url) {
        $(document).on('change', $el, function(e) {
            e.preventDefault();
            var selectedVal=$(this).val();
            var newUrl = url+selectedVal;
            window.location.href=newUrl;
        });
    }
    changer("#optx",  '<?=base_url($ci->urlController()->index);?>/');
    </script>
</div>
