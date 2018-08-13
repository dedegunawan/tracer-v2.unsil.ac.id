<div class="row">

    <div class="col-md-6 col-md-offset-3">
        <div class="form-group text-center">
            <label>Pilih Pertanyaan</label>
            <select name="optY" id="optY" class="form-control">
                <option value="0">
                    --Pilih Salah Satu--
                </option>
                <?php
                foreach ($pertanyaanA as $key => $pr) {
                    ?>
                    <option value="<?=$key;?>"
                        <?php
                        $selected = $ci->uri->segment(4);
                        if (@$selected == "$key") {
                            echo " selected='selected' ";
                        }
                        ?>

                    >
                        <?=@$pr['pertanyaan'];?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <script>
    function changerB($el) {
        $(document).on('change', $el, function(e) {
            e.preventDefault();
            var selectedVal=$(this).val();
            var newUrl = '<?=base_url($ci->urlController()->index.'/'.$ci->uri->segment(3));?>/'+selectedVal;
            window.location.href=newUrl;
        });
    }
    changerB("#optY");
    </script>
</div>
