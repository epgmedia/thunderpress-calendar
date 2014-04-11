  <table class="table" id="authorizenetoptions" style="display:none"   >
    <tr>
      <td class="row3" width="150"><?php _e("Card Holder Name :","templatic"); ?></td>
      <td class="row3"><input type="text" value="" id="cardholder_name" name="cardholder_name" class="textfield"/></td>
    </tr>
    <tr>
      <td class="row3"><?php _e("Card Type : ","templatic");?></td>
      <td class="row3"><select class="select_s" id="cc_type" name="cc_type" >
          <option value=""><?php _e("-- select card type --","templatic");?></option>
          <option value="VISA"><?php _e("Visa","templatic");?></option>
          <option value="DELTA"><?php _e("Visa Delta","templatic");?></option>
          <option value="UKE"><?php _e("Visa Electron","templatic");?></option>
          <option value="MC"><?php _e("Master Card","templatic");?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="row3"><?php _e("Credit/Debit Card number : ","templatic");?></td>
      <td class="row3"><input type="text" autocomplete="off" size="25" maxlength="25" id="cc_number" name="cc_number" class="textfield"/></td>
    </tr>
    <tr>
      <td class="row3"><?php _e("Expiry Date :","templatic");?> </td>
      <td class="row3"><select  class="select_s2" id="cc_month" name="cc_month">
          <option selected="selected" value=""><?php _e("month","templatic");?></option>
          <option value="01"><?php _e("01","templatic");?></option>
          <option value="02"><?php _e("02","templatic");?></option>
          <option value="03"><?php _e("03","templatic");?></option>
          <option value="04"><?php _e("04","templatic");?></option>
          <option value="05"><?php _e("05","templatic");?></option>
          <option value="06"><?php _e("06","templatic");?></option>
          <option value="07"><?php _e("07","templatic");?></option>
          <option value="08"><?php _e("08","templatic");?></option>
          <option value="09"><?php _e("09","templatic");?></option>
          <option value="10"><?php _e("10","templatic");?></option>
          <option value="11"><?php _e("11","templatic");?></option>
          <option value="12"><?php _e("12","templatic");?></option>
        </select>
        <select class="select_s2" id="cc_year" name="cc_year">
          <option selected="selected" value=""><?php _e("year","templatic");?></option>
          <?php for($y=date('Y');$y<date('Y')+5;$y++){?>
          <option value="<?php echo $y;?>"><?php echo $y;?></option>
          <?php }?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="row3"><?php _e("CV2 (3 digit security code) : ","templatic");?></td>
      <td class="row3"><input type="text" autocomplete="off" size="4" maxlength="5" id="cv2" name="cv2" class="textfield2"/></td>
    </tr>
  </table>